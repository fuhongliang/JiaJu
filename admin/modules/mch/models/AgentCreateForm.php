<?php
namespace app\modules\mch\models;

use app\models\AgentDistrict;
use app\models\AuthRoleUser;
use app\models\User;
use Yii;

class AgentCreateForm extends MchModel
{

    public $nickname;
    public $username;
    public $password;
    public $agent_province_id;
    public $agent_city_id;
    public $district;
    public $role;


    public function rules()
    {
        return [
            [['nickname', 'username', 'password','agent_province_id','agent_city_id'], 'required'],
            [['role','is_agent','district'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'nickname' => '用户昵称',
            'username' => '用户名',
            'password' => '密码',
        ];
    }

    public function store()
    {
        if (!$this->validate()) {
            return $this->getErrorResponse();
        }
        //用户名是否已存在
        $check = User::findOne(['username' => $this->username,'is_delete' => 0]);
        if (!empty($check)) {
            return [
                'code' => 1,
                'msg' => '用户名已存在'
            ];
        }
        if (empty($this->agent_province_id)) {
            return [
                'code' => 1,
                'msg' => '请选择省份'
            ];
        }
        if (empty($this->agent_city_id)) {
            return [
                'code' => 1,
                'msg' => '请选择城市'
            ];
        }
        if (empty($this->district)) {
            return [
                'code' => 1,
                'msg' => '请选择地区'
            ];
        }

        //判断区域是否有其他代理
        $check = AgentDistrict::find()->where(['district_id' => $this->district,'is_delete' => 0])->one();
        if (!empty($check)) {
            return [
                'code' => 1,
                'msg' => '所选地区有其他代理人',
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();

        $model = new User();
        $model->attributes = $this->attributes;
        $model->type = 2; //代理
        $model->password = Yii::$app->security->generatePasswordHash($this->password, 5);
        $model->auth_key = Yii::$app->security->generateRandomString();
        $model->access_token = Yii::$app->security->generateRandomString();
        $model->addtime = time();
        $model->is_delete = 0;
        $model->is_agent = 1;
        $model->avatar_url = '0';//TODO 数据库没有设置默认值
        $model->store_id = $this->getCurrentStoreId();

        if ($model->save()) {
            $this->storeRoleUser($model->id);
            //区域
            foreach ($this->district as $v) {
                $agentDistrict = new AgentDistrict();
                $agentDistrict->user_id = $model->id;
                $agentDistrict->district_id = $v;
                $agentDistrict->save();
            }
            $transaction->commit();
            return [
                'code' => 0,
                'msg' => '添加成功'
            ];
        }
        $transaction->rollBack();
        return $this->getErrorResponse($model);

    }


    public function storeRoleUser($userId)
    {
        $model = AuthRoleUser::findOne(['user_id' => $userId]);
        if (empty($model)) {
            $model = new AuthRoleUser();
        }
        $model->user_id = $userId;
        $model->role_id = 6;
        $model->save();
        return true;
    }




}