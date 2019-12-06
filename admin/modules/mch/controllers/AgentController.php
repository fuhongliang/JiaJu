<?php
namespace app\modules\mch\controllers;

use app\models\AgentDistrict;
use app\models\AuthRoleUser;
use app\models\District;
use app\models\User;
use app\modules\mch\models\AgentCreateForm;
use app\modules\mch\models\AgentUpdateForm;
use app\modules\mch\models\permission\user\UpdateAdminUserForm;
use Yii;
use yii\data\Pagination;

class AgentController extends Controller
{

    public function actionIndex()
    {
        $limit = 10;
        $model = User::find()->andWhere(['type' => User::USER_TYPE, 'store_id' => $this->store->id, 'is_delete' => 0]);
        $pagination = new Pagination(['totalCount' => $model->count(), 'pageSize' => $limit]);
        $list = $model->limit($limit)->offset($pagination->offset)->asArray()->all();

        foreach ($list as $k=>$v) {
            $province = District::find()->where(['id'=> $v['agent_province_id']])->one();
            $city = District::find()->where(['id' =>$v['agent_city_id']])->one();
            //负责地区
            $district = AgentDistrict::find()->where(['user_id' => $v['id'], 'is_delete' => 0])->asArray()->select('*')
                ->all();
            $district_id = [];
            foreach ($district as $dk=>$dv) {
                $district_id[] = $dv['district_id'];
            }
            $district_list = District::find()->where(['id' => $district_id])
                ->asArray()->all();
            $tmp = [];
            foreach($district_list as $key => $value) {
                $tmp[] = $value['name'];
            }
            $district_name = implode(',', $tmp);
            $list[$k]['province'] = $province->name;
            $list[$k]['city'] = $city->name;
            $list[$k]['district_name'] = $district_name;
        }

        return $this->render('index', ['list' => $list, 'pagination' => $pagination]);
    }


    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $model = new AgentCreateForm();
            $model->attributes = $data;
            return $model->store();
        } else {
            $query = District::find()->alias('d')->where(['level' => 'province']);
            $list = $query->orderBy('d.id')->asArray()->select('*')->all();
            return $this->render('create',[
                'province' => $list,
            ]);
        }
    }

    public function actionUpdate($id=0)
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $model = new AgentUpdateForm();
            $model->attributes = $data;
            $model->userId = $id;
            return $model->update();
        } else {
            $edit = User::find()->andWhere(['id' => $id])->with('roleUser')->one();

            $province = District::find()->where(['id'=> $edit->agent_province_id])->one();

            $city = District::find()->where(['id' => $edit->agent_city_id])->one();

            $district_list = District::find()->where(['parent_id' => $edit->agent_city_id])
                ->asArray()->select('*')->all();

            //负责地区
            $district = AgentDistrict::find()->where(['user_id' => $id, 'is_delete' => 0])->asArray()->select('*')
                ->all();
            $district_id = [];
            foreach ($district as $k=>$v) {
                $district_id[] = $v['district_id'];
            }

            return $this->render('edit',[
                'edit' => $edit,
                'province' => $province,
                'city' => $city,
                'district_list' => $district_list,
                'district' => $district,
                'district_id' =>$district_id
            ]);
        }
    }



    public function actionSearchDistrict($id)
    {
        $query = District::find()->alias('d')->where(['parent_id' => $id]);
        $list = $query->orderBy('d.id')->asArray()->select('*')->all();
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => (object)[
                'list' => $list,
            ],
        ];
    }


    /**
     * @desc 删除代理
     * @param $id
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionDestroy($id)
    {
        $transaction = Yii::$app->db->beginTransaction();

        $model = User::findOne($id);
        if ($model) {
            $model->is_delete = 1;
            $model->save();
            //删除角色-用户
            $destroyed = AuthRoleUser::deleteAll(['user_id' => $id]);
            //删除代理商家
            AgentDistrict::updateAll(['is_delete' => 1],[
                'user_id'=>$id,
            ]);
            $transaction->commit();
            return [
                'code' => 0,
                'msg' => '删除成功'
            ];
        }
        $transaction->rollBack();
        return [
            'code' => 1,
            'msg' => '删除失败'
        ];
    }






}