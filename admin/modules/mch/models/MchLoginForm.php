<?php
namespace app\modules\mch\models;

use app\models\User;
use Yii;

class MchLoginForm extends MchModel
{
    public $username;
    public $mch_store_id;
    public $password;
    public $captcha_code;

    public function rules()
    {
        return [
            [['username', 'captcha_code'], 'trim'],
            [['username', 'captcha_code', 'password', 'mch_store_id'], 'required'],
            [['captcha_code',], 'captcha', 'captchaAction' => 'mch/permission/passport/captcha',],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'captcha_code' => '图片验证码',
        ];
    }

    public function login()
    {
        if (!$this->validate())
            return $this->errorResponse;

        $admin = User::findOne([
            'username' => $this->username,
            'type' => User::USER_TYPE,
            'store_id' => $this->mch_store_id,
        ]);
        if (!$admin) {
            return [
                'code' => 1,
                'msg' => '账号不存在',
            ];
        }
        if ($admin->is_delete) {
            return [
                'code' => 1,
                'msg' => '账号已被删除，请联系管理员'
            ];
        }
        if (!\Yii::$app->security->validatePassword($this->password, $admin->password)) {
            return [
                'code' => 1,
                'msg' => '用户名或密码错误',
            ];
        }

        //清除其它类型登录的认证
        Yii::$app->admin->logout();
        Yii::$app->user->logout();
        Yii::$app->mchRoleAdmin->login($admin);
        Yii::$app->session->set('store_id', $admin->store_id);

        return [
            'code' => 0,
            'msg' => '登录成功',
        ];
    }
}