<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 
 * author: wxf
 */

namespace app\models\common\admin\order;

use app\models\Goods;
use app\models\Model;
use app\models\Order;
use app\models\OrderDetail;
use app\models\OrderRefund;
use Yii;

class CommonOrderStatistics extends Model
{
    /**
     * 获取订单商品总数(去除申请退款成功的)
     * @param null $startTime
     * @param null $endTime
     * @param int $mchId
     * @return int
     */
    public function getOrderGoodsCount($startTime = null, $endTime = null, $mchId = 0)
    {
        $query = Order::find()->where([
            'is_delete' => Order::IS_DELETE_FALSE,
            'is_cancel' => Order::IS_CANCEL_FALSE,
            'store_id' => $this->getCurrentStoreId(),
            'mch_id' => $mchId,// 区分商城和多商户，0.商城| > 0.多商户
        ])->andWhere(['or', ['is_pay' => Order::IS_PAY_TRUE], ['pay_type' => Order::PAY_TYPE_COD]]);

        if ($startTime !== null) {
            $query->andWhere(['>=', 'addtime', $startTime]);
        }
        if ($endTime !== null) {
            $query->andWhere(['<=', 'addtime', $endTime]);
        }

        $orders = $query->with('detail', 'refund')->all();
        $goodsCount = 0;
        $refund = 0;
        foreach ($orders as $item) {
            foreach ($item->detail as $i) {
                $goodsCount = $goodsCount + $i->num;
            }
        }

        foreach ($orders as $item) {
            foreach ($item->refund as $i) {
                $refund = $i->status == OrderRefund::STATUS_REFUND_AGREE ? $refund + 1 : $refund;
            }
        }

        return intval($goodsCount - $refund);
    }


    /**
     * 获取订单金额总数（实际付款）
     * @param null $startTime
     * @param null $endTime
     * @param int $mchId
     * @return string
     */
    public function getOrderPriceCount($startTime = null, $endTime = null, $mchId = 0)
    {
        $query = Order::find()->andWhere([
            'is_delete' => Order::IS_DELETE_FALSE,
            'is_cancel' => Order::IS_CANCEL_FALSE,
            'store_id' => $this->getCurrentStoreId(),
            'mch_id' => $mchId,// 区分商城和多商户，0.商城| > 0.多商户
        ])->andWhere(['or', ['is_pay' => Order::IS_PAY_TRUE], ['pay_type' => Order::PAY_TYPE_COD]]);

        if ($startTime !== null) {
            $query->andWhere(['>=', 'addtime', $startTime]);
        }
        if ($endTime !== null) {
            $query->andWhere(['<=', 'addtime', $endTime]);
        }
        $orders = $query->with(['refund' => function ($query) {
            $query->andWhere(['type' => OrderRefund::TYPE_REFUND, 'status' => OrderRefund::STATUS_REFUND_AGREE]);
        }])->all();

        $totalPrice = 0;
        $refundPrice = 0;
        foreach ($orders as $item) {
            $totalPrice = $totalPrice + $item->total_price;
            foreach ($item->refund as $i) {
                $refundPrice = $refundPrice + $i->refund_price;
            }
        }

        return number_format(doubleval($totalPrice - $refundPrice), 2);
    }


    /**
     * 获取订单总数
     * @param null $startTime
     * @param null $endTime
     * @param int $mchId
     * @return int
     */
    public function getOrderCount($startTime = null, $endTime = null, $mchId = 0)
    {
        $query = Order::find()->andWhere([
            'is_delete' => Order::IS_DELETE_FALSE,
            'is_cancel' => Order::IS_CANCEL_FALSE,
            'store_id' => $this->getCurrentStoreId(),
            'mch_id' => $mchId,// 区分商城和多商户，0.商城| > 0.多商户
        ])->andWhere(['or', ['is_pay' => Order::IS_PAY_TRUE], ['pay_type' => Order::PAY_TYPE_COD]]);

        if ($startTime !== null) {
            $query->andWhere(['>=', 'addtime', $startTime]);
        }
        if ($endTime !== null) {
            $query->andWhere(['<=', 'addtime', $endTime]);
        }
        $count = $query->count();
        return $count ? intval($count) : 0;
    }

    /**
     * 获取售后中订单数
     * @param int $mchId
     * @return int
     */
    public function getOrderRefundingCount($mchId = 0)
    {
        $count = OrderRefund::find()->alias('or')
            ->leftJoin(['o' => Order::tableName()], 'o.id=or.order_id')->where([
                'or.store_id' => $this->getCurrentStoreId(),
                'or.is_delete' => Model::IS_DELETE_FALSE,
                'or.status' => OrderRefund::STATUS_IN,
                'o.mch_id' => $mchId
            ])->count();

        return $count ? intval($count) : 0;
    }


    /**
     * 获取待发货的订单数
     * @param int $mchId
     * @return int
     */
    public function getOrderNoSendCount($mchId = 0)
    {
        $count = Order::find()->where([
            'store_id' => $this->getCurrentStoreId(),
            'is_delete' => Model::IS_DELETE_FALSE,
            'is_send' => Order::IS_SEND_FALSE,
            'mch_id' => $mchId
        ])->andWhere(['or', ['is_pay' => Order::IS_PAY_TRUE], ['pay_type' => Order::PAY_TYPE_COD]])->count();

        return $count ? intval($count) : 0;
    }

    /**
     * 获取商品销量排行
     * @param null $startTime
     * @param null $endTime
     * @param int $mchId
     * @param int $limit
     * @return mixed
     */
    public function getGoodsSaleTopList($startTime = null, $endTime = null, $mchId = 0, $limit = 10)
    {
        $query = OrderDetail::find()->alias('od')
            ->leftJoin(['o' => Order::tableName()], 'od.order_id=o.id')
            ->leftJoin(['g' => Goods::tableName()], 'od.goods_id=g.id')
            ->where([
                'g.store_id' => $this->getCurrentStoreId(),
                'g.is_delete' => Model::IS_DELETE_FALSE,
                'o.is_delete' => Model::IS_DELETE_FALSE,
                'od.is_delete' => Model::IS_DELETE_FALSE,
                'g.mch_id' => $mchId,
                'o.mch_id' => $mchId
            ])->andWhere(['or', ['o.is_pay' => Order::IS_PAY_TRUE], ['o.pay_type' => Order::PAY_TYPE_COD]]);
        if ($startTime !== null) {
            $query->andWhere(['>=', 'o.addtime', $startTime]);
        }
        if ($endTime !== null) {
            $query->andWhere(['<=', 'o.addtime', $endTime]);
        }
        return $query->select('g.name,SUM(od.num) AS num')
            ->groupBy('od.goods_id')->orderBy('num DESC')
            ->limit($limit)->asArray()->all();
    }

}