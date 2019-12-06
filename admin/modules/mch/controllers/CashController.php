<?php
namespace app\modules\mch\controllers;

use app\modules\mch\models\mch\CashListForm;
use app\modules\mch\models\mch\CashConfirmForm;
use app\modules\mch\models\mch\MchDepositConfirmForm;
use app\modules\mch\models\MchDepositListForm;

class CashController extends Controller
{

    public function actionIndex()
    {

    }


    /**
     * @desc 商家提现
     */
    public function actionMchCashOut()
    {
        $get = \Yii::$app->request->get();
        if (!isset($get['status']) || $get['status'] === null || $get['status'] === '') {
            $get['status'] = -1;
        }
        $form = new CashListForm();
        $form->attributes = $get;
        $form->store_id = $this->store->id;
        $res = $form->search();
        return $this->render('mch-cash-out', [
            'get' => $get,
            'list' => isset($res['data']['list']) ? $res['data']['list'] : [],
            'pagination' => isset($res['data']['pagination']) ? $res['data']['pagination'] : null,
        ]);
    }

    /**
     * @desc 转账 | 确认打款 | 拒绝
     * @return array
     */
    public function actionMchCashSubmit()
    {
        $form = new CashConfirmForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        return $form->save();
    }

    /**
     * @desc 商家保证金
     */
    public function actionMchDeposit()
    {
        $get = \Yii::$app->request->get();
        if (!isset($get['status']) || $get['status'] === null || $get['status'] === '') {
            $get['status'] = -1;
        }
        $form = new MchDepositListForm();
        $form->attributes = $get;
        $form->store_id = $this->store->id;
        $res = $form->search();
        return $this->render('mch-deposit', [
            'get' => $get,
            'list' => isset($res['data']['list']) ? $res['data']['list'] : [],
            'pagination' => isset($res['data']['pagination']) ? $res['data']['pagination'] : null,
        ]);
    }


    public function actionMchDepositSubmit()
    {
        $form = new MchDepositConfirmForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        return $form->save();
    }






}

























