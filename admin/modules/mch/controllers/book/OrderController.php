<?php

/**
 * Created by PhpStorm.
 * User: peize
 * Date: 2017/12/21
 * Time: 14:25
 */

namespace app\modules\mch\controllers\book;

use app\models\YyOrder;
use app\models\YyWechatTplMsgSender;
use app\modules\mch\models\book\OrderForm;
use app\modules\mch\models\ExportList;

class OrderController extends Controller
{

    /**
     * @return string
     * 订单列表
     */
    public function actionIndex()
    {
        $form = new OrderForm();
        $form->attributes = \Yii::$app->request->get();
        $form->attributes = \Yii::$app->request->post();
        $form->store_id = $this->store->id;
        $arr = $form->getList();

        $f = new ExportList();
        $f->order_type = 3;
        $exportList = $f->getList();

        return $this->render('index', [
            'list' => $arr['list'],
            'pagination' => $arr['p'],
            'row_count' => $arr['row_count'],
            'exportList'=>\Yii::$app->serializer->encode($exportList)
        ]);
    }

    public function actionRefund()
    {
        $order_id = \Yii::$app->request->get('order_id');
        $order = YyOrder::find()
            ->andWhere([
                'id' => $order_id,
                'is_delete' => 0,
                'store_id' => $this->store->id,
                'is_pay' => 1,
                'is_refund' => 0,
                'apply_delete' => 1,
            ])
            ->one();
        if (!$order) {
            return [
                'code' => 1,
                'msg' => '订单错误1',
            ];
        }

        if ($order->pay_price < 0) {
            return [
                'code' => 1,
                'msg' => '订单错误2',
            ];
        }
        /** @var Wechat $wechat */
        $wechat = isset(\Yii::$app->controller->wechat) ? \Yii::$app->controller->wechat : null;

        $data = [
            'out_trade_no' => $order->order_no,
            'out_refund_no' => $order->order_no,
            'total_fee' => $order->pay_price * 100,
            'refund_fee' => $order->pay_price * 100,
        ];
        $res = $wechat->pay->refund($data);
        if (!$res) {
            return [
                'code' => 1,
                'msg' => '订单取消失败，退款失败，服务端配置出错',
            ];
        }
        if ($res['return_code'] != 'SUCCESS') {
            return [
                'code' => 1,
                'msg' => '订单取消失败，退款失败，' . $res['return_msg'],
                'res' => $res,
            ];
        }
        if ($res['result_code'] != 'SUCCESS') {
            return [
                'code' => 1,
                'msg' => '订单取消失败，退款失败，' . $res['err_code_des'],
                'res' => $res,
            ];
        }
        $order->is_refund = 1;
        if ($order->save()) {
            $msg_sender = new YyWechatTplMsgSender($this->store->id, $order->id, $wechat);
            if ($order->is_pay) {
                $remark = '订单已退款，退款金额：' . $order->pay_price;
                $refund_reason = '用户取消';
                $msg_sender->refundMsg($order->pay_price, $refund_reason, $remark);
            }
            return [
                'code' => 0,
                'msg' => '订单已退款',
            ];
        } else {
            return [
                'code' => 1,
                'msg' => '订单退款失败',
            ];
        }
    }

}