<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 
 * author: wxf
 */

namespace app\modules\mch\models\permission\user;

use app\models\AuthRoleUser;
use app\models\User;
use app\modules\mch\models\MchModel;
use Yii;

class StoreAdminUserForm extends MchModel
{
    public $nickname;
    public $username;
    public $password;
    public $role;

    public function rules()
    {
        return [
            [['nickname', 'username', 'password'], 'required'],
            [['role'], 'safe']
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
        $transaction = Yii::$app->db->beginTransaction();

        $model = new User();
        $model->attributes = $this->attributes;
        $model->type = User::USER_TYPE;
        $model->password = \Yii::$app->security->generatePasswordHash($this->password, 5);
        $model->auth_key = \Yii::$app->security->generateRandomString();
        $model->access_token = \Yii::$app->security->generateRandomString();
        $model->addtime = time();
        $model->is_delete = \app\models\Model::IS_DELETE_FALSE;
        $model->avatar_url = '0';//TODO 数据库没有设置默认值
        $model->store_id = $this->getCurrentStoreId();

        if ($model->save()) {

            $this->storeRoleUser($model->id);
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
        if (empty($this->role)) {
            return false;
        }

        $attributes = [];
        foreach ($this->role as $item) {
            $attributes[] = [
                $item, $userId,
            ];
        }

        $query = Yii::$app->db->createCommand();
        $insert = $query->batchInsert(AuthRoleUser::tableName(), ['role_id', 'user_id'], $attributes)->execute();

        if (!$insert) {
            return $this->getErrorResponse($insert);
        }

        return true;

    }
}