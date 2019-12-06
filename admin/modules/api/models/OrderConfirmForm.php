<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/7/20
 * Time: 10:25
 */

namespace app\modules\api\models;


use app\extensions\PinterOrder;
use app\models\Level;
use app\models\Order;
use app\models\OrderDetail;
use app\models\PrinterSetting;
use app\models\Register;
use app\models\User;

class OrderConfirmForm extends Model
{
    public $store_id;
    public $user_id;
    public $order_id;

    public function rules()
    {
        return [
            [['order_id'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this->errorResponse;
        }
        $order = Order::findOne([
            'store_id' => $this->store_id,
            'user_id' => $this->user_id,
            'id' => $this->order_id,
            'is_send' => 1,
            'is_delete' => 0,
        ]);
        if (!$order) {
            return [
                'code' => 1,
                'msg' => '订单不存在'
            ];
        }
        $order->is_confirm = 1;
        $order->confirm_time = time();
        if($order->pay_type == 2){
            $order->is_pay = 1;
            $order->pay_time = time();
        }
/*
        $user = User::findOne(['id' => $order->user_id, 'store_id' => $this->store_id]);
        $order_money = Order::find()->where(['store_id' => $this->store_id, 'user_id' => $user->id, 'is_delete' => 0])
            ->andWhere(['is_pay' => 1, 'is_confirm' => 1])->select([
                'sum(pay_price)'
            ])->scalar();
        $next_level = Level::find()->where(['store_id' => $this->store_id, 'is_delete' => 0,'status'=>1])
            ->andWhere(['<', 'money', $order_money])->orderBy(['level' => SORT_DESC])->asArray()->one();
        if ($user->level < $next_level['level']) {
            $user->level = $next_level['level'];
            $user->save();
        }
*/

        if ($order->save()) {
            $this->sendIntegral();
            $printer_order = new PinterOrder($this->store_id,$order->id, 'confirm',0);
            $res = $printer_order->print_order();
            return [
                'code' => 0,
                'msg' => '已确认收货'
            ];
        } else {
            return [
                'code' => 1,
                'msg' => '确认收货失败'
            ];
        }
    }

    /**
     * 确认收货后 发放积分
     * @return array
     */
    public function sendIntegral(){
        $order = Order::findOne([
            'store_id' => $this->store_id,
            'user_id' => $this->user_id,
            'id' => $this->order_id,
            'is_send' => 1,
            'is_delete' => 0,
            'give_integral' => 0
        ]);
        if (!$order) {
            return;
        }
        $order->give_integral = 1;
        $order->save();
        $integral = OrderDetail::find()->where(['order_id'=>$this->order_id,'is_delete'=>0])->sum('integral');
        if($integral > 0){
            $user = User::findOne([
                'store_id' => $this->store_id,
                'id' => $this->user_id
            ]);
            $user->integral = $user->integral+$integral;
            if($user->save()){
                $register = new Register();
                $register->store_id = $this->store_id;
                $register->user_id = $user->id;
                $register->register_time = date('Y/m/d');
                $register->addtime = time();
                $register->continuation = 0;
                $register->type = 7;
                $register->integral = $integral;
                $register->order_id = $order->id;
                $register->save();
            }
        }
    }
}