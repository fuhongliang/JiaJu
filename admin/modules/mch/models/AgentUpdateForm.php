<?php
namespace app\modules\mch\models;
use app\models\AgentDistrict;
use app\models\User;
use Yii;
class AgentUpdateForm extends MchModel
{
    public $userId;
    public $nickname;
    public $username;
    public $district;
    public $role;

    public function rules()
    {
        return [
            [['nickname', 'username'], 'required'],
            [['role','district'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'nickname' => '用户昵称',
            'username' => '用户名',
        ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return $this->getErrorResponse();
        }
        //用户名是否已存在
        $check = User::find()->where(['username' => $this->username,'is_delete' => 0])
            ->andWhere(['<>', 'id', $this->userId])->one();
        if (!empty($check)) {
            return [
                'code' => 1,
                'msg' => '用户名已存在',
            ];
        }

        if (empty($this->district)) {
            return [
                'code' => 1,
                'msg' => '请选择地区',
            ];
        }

        //判断区域是否有其他代理
        $check = AgentDistrict::find()->where(['district_id' => $this->district,'is_delete' => 0])
            ->andWhere(['<>', 'user_id', $this->userId])->one();
        if (!empty($check)) {
            return [
                'code' => 1,
                'msg' => '所选地区有其他代理人',
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();
        $model = User::findOne($this->userId);
        $model->attributes = $this->attributes;
        if ($model->save()) {
            //更新区域
            AgentDistrict::updateAll(['is_delete' => 1], ['and', [
            'user_id'=>$this->userId
            ],['not in', 'district_id', $this->district]]);
//            $sql = "update ".AgentDistrict::tableName()." set is_delete=1 WHERE "
//                ." user_id=".$this->userId
//                ." and parent_category=".$this->parent_category
//                ." and level_id=".$this->level_id
//                ." and user_id=".$this->user_id
//                ." and brand_id <> ".$this->brand_id;
//
//            \Yii::$app->db->createCommand($sql)->execute();

            foreach ($this->district as $v) {
                $agentDistrict = AgentDistrict::find()->where(['user_id' => $this->userId])
                    ->andWhere(['district_id' => $v])->one();
                if (empty($agentDistrict)) {
                    $agentDistrict = new AgentDistrict();
                }
                $agentDistrict->user_id = $this->userId;
                $agentDistrict->district_id = $v;
                $agentDistrict->is_delete = 0;
                $agentDistrict->save();
            }

            $transaction->commit();
            //更新用户权限后，删除该用户的权限缓存
            $cacheKey = $model->store_id . $model->access_token;
            Yii::$app->getCache()->delete($cacheKey);
            return [
                'code' => 0,
                'msg' => '更新成功'
            ];
        }
        $transaction->rollBack();
        return $this->getErrorResponse($model);
    }



}