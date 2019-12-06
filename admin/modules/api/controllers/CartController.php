<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/27
 * Time: 1:06
 */

namespace app\modules\api\controllers;


use app\hejiang\ApiResponse;
use app\hejiang\BaseApiResponse;
use app\models\Cart;
use app\modules\api\behaviors\LoginBehavior;
use app\modules\api\models\AddCartForm;
use app\modules\api\models\CartDeleteForm;
use app\modules\api\models\CartListForm;

class CartController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'login' => [
                'class' => LoginBehavior::className(),
            ],
        ]);
    }

    public function actionList()
    {
        $form = new CartListForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        return new BaseApiResponse($form->search());
    }

    public function actionAddCart()
    {
        if (\Yii::$app->request->isPost) {
            $form = new AddCartForm();
            $form->attributes = \Yii::$app->request->post();
            $form->store_id = $this->store->id;
            $form->user_id = \Yii::$app->user->id;
            return new BaseApiResponse($form->save());
        }
    }

    public function actionDelete()
    {
        $form = new CartDeleteForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        return new BaseApiResponse($form->save());
    }

    public function actionCartEdit()
    {
        if (\Yii::$app->request->isPost) {
            $form = new CartListForm();
            $form->store_id = $this->store->id;
            $form->user_id = \Yii::$app->user->id;
            $form->list = \Yii::$app->request->post('list');
            $form->mch_list = \Yii::$app->request->post('mch_list');
            return new BaseApiResponse($form->save());
        }
    }



    public function actionEditCart()
    {
        //cart_id_list [{"cart_id":"2","num":"10"}]
        if (\Yii::$app->request->isPost) {
            $store_id = $this->store->id;
            $user_id = \Yii::$app->user->id;
            $list = \Yii::$app->request->post('cart_id_list');
            $cart_list = json_decode($list, true);
            if (!empty($cart_list)) {
                foreach ($cart_list as $v) {
                    $form = Cart::find()->where(['store_id' => $store_id, 'is_delete' => 0])->where('id=:id', [':id' => $v['cart_id']])->one();
                    $form->num = $v['num'];
                    $form->save();
                }
                $response = [
                    'code' => 0,
                    'msg' => 'success',
                ];
                return new BaseApiResponse($response);
            }
        }
    }



}