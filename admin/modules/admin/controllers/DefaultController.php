<?php
namespace app\modules\admin\controllers;


use app\models\Admin;
use app\models\Store;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $admin = \Yii::$app->admin->identity;
        if ($admin->id != 1) {
            $condition = [
                'id' => 4,
                'is_delete' => 0,
            ];
            $store = Store::findOne($condition);
            if (!$store) {
                \Yii::$app->response->redirect(\Yii::$app->request->referrer)->send();
                return;
            }
            \Yii::$app->session->set('store_id', $store->id);
            \Yii::$app->response->redirect(\Yii::$app->urlManager->createUrl(['mch/store/index']))->send();
        } else {
            return $this->render('index');
        }
    }

    public function actionAlterPassword()
    {
        if (\Yii::$app->request->isPost) {
            /* @var  Admin $admin */
            $admin = \Yii::$app->admin->identity;
            $old_password = \Yii::$app->request->post('old_password');
            $new_password = \Yii::$app->request->post('new_password');
            if ($old_password == "" || $new_password == "") {
                return [
                    'code' => 1,
                    'msg' => '原密码和新密码不能为空',
                ];
            }
            if (!\Yii::$app->security->validatePassword($old_password, $admin->password)) {
                return [
                    'code' => 1,
                    'msg' => '原密码不正确',
                ];
            }
            $admin->password = \Yii::$app->security->generatePasswordHash($new_password);
            if ($admin->save()) {
                \Yii::$app->admin->logout();
                return [
                    'code' => 0,
                    'msg' => '修改成功',
                ];
            } else {
                return [
                    'code' => 0,
                    'msg' => '修改失败',
                ];
            }
        }
    }
}