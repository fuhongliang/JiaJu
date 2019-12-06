<?php
namespace app\modules\admin\controllers;

use app\modules\admin\models\LoginForm;
use app\modules\admin\models\password\ResetPasswordForm;
use app\modules\admin\models\password\SendSmsCodeForm;
use yii\captcha\CaptchaAction;

class PassportController extends Controller
{
    public $layout = 'passport';

    public function behaviors()
    {
        return [];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => CaptchaAction::className(),
                'minLength' => 4,
                'maxLength' => 4,
            ],
            'sms-code-captcha' => [
                'class' => CaptchaAction::className(),
                'minLength' => 4,
                'maxLength' => 5,
            ],
        ];
    }


    public function actionLogin()
    {
        if (\Yii::$app->request->isPost) {
            $form = new LoginForm();
            $form->attributes = \Yii::$app->request->post();
            return $form->login();
        } else {
            return $this->render('login');
        }
    }

    public function actionLogout()
    {
        \Yii::$app->admin->logout();
        \Yii::$app->response->redirect(\Yii::$app->urlManager->createUrl(['admin']))->send();
    }

    //发送短信验证码，修改密码用
    public function actionSendSmsCode()
    {
        $form = new SendSmsCodeForm();
        $form->attributes = \Yii::$app->request->post();
        return $form->send();
    }

    //通过短信验证重置密码
    public function actionResetPassword()
    {
        $form = new ResetPasswordForm();
        $form->attributes = \Yii::$app->request->post();
        return $form->save();
    }

}
