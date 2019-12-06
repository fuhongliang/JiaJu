<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/7/27
 * Time: 14:14
 */

namespace app\modules\mch\models;


use app\models\common\admin\order\CommonOrderStatistics;
use app\models\common\admin\store\CommonStore;
use app\models\Goods;
use app\models\Order;
use app\models\OrderDetail;
use app\models\User;
use app\modules\api\models\Model;

class StoreDataForm extends MchModel
{
    public $store_id;
    public $is_offline;
    public $user_id;
    public $clerk_id;
    public $parent_id;
    public $shop_id;

    public function search()
    {
        //今日
        $todayStartTime = strtotime(date('Y-m-d 00:00:00'));
        $todayEndTime = strtotime(date('Y-m-d 23:59:59'));
        //昨日
        $yesterdayStartTime = strtotime(date('Y-m-d 00:00:00') . ' -1 day');
        $yesterdayEndTime = strtotime(date('Y-m-d 23:59:59') . ' -1 day');
        //最近7天
        $lastSevenStartTime = strtotime(date('Y-m-d 00:00:00') . ' -6 day');
        $lastSevenEndTime = strtotime(date('Y-m-d 23:59:59'));
        //最近30天
        $lastThirtyStartTime = strtotime(date('Y-m-d 00:00:00') . ' -29 day');
        $lastThirtyEndTime = strtotime(date('Y-m-d 23:59:59'));

        $data = [
            'panel_1' => $this->getStoreInfo(),
            'panel_2' => [
                'goods_zero_count' => $this->getCountZeroGoodsNum(),
                'order_no_send_count' => $this->getOrderNoSendCount(),
                'order_refunding_count' => $this->getOrderRefundingCount(),
            ],
            'panel_3' => [
                'data_1' => [
                    'order_goods_count' => $this->getOrderGoodsCount($todayStartTime, $todayEndTime),
                    'order_price_count' => $this->getOrderPriceCount($todayStartTime, $todayEndTime),
                    'order_price_average' => $this->getOrderPriceAverage($todayStartTime, $todayEndTime),
                ],
                'data_2' => [
                    'order_goods_count' => $this->getOrderGoodsCount($yesterdayStartTime, $yesterdayEndTime),
                    'order_price_count' => $this->getOrderPriceCount($yesterdayStartTime, $yesterdayEndTime),
                    'order_price_average' => $this->getOrderPriceAverage($yesterdayStartTime, $yesterdayEndTime),
                ],
                'data_3' => [
                    'order_goods_count' => $this->getOrderGoodsCount($lastSevenStartTime, $lastSevenEndTime),
                    'order_price_count' => $this->getOrderPriceCount($lastSevenStartTime, $lastSevenEndTime),
                    'order_price_average' => $this->getOrderPriceAverage($lastSevenStartTime, $lastSevenEndTime),
                ],
                'data_4' => [
                    'order_goods_count' => $this->getOrderGoodsCount($lastThirtyStartTime, $lastThirtyEndTime),
                    'order_price_count' => $this->getOrderPriceCount($lastThirtyStartTime, $lastThirtyEndTime),
                    'order_price_average' => $this->getOrderPriceAverage($lastThirtyStartTime, $lastThirtyEndTime),
                ],
            ],
            'panel_4' => [
                'order_goods_data' => $this->getDaysOrderGoodsData(7),
                'order_goods_price_data' => $this->getDaysOrderGoodsPriceData(7),
            ],
            'panel_5' => [
                'data_1' => $this->getGoodsSaleTopList(
                    $todayStartTime,
                    $todayEndTime,
                    5
                ),
                'data_2' => $this->getGoodsSaleTopList(
                    $yesterdayStartTime,
                    $yesterdayEndTime,
                    5
                ),
                'data_3' => $this->getGoodsSaleTopList(
                    $lastSevenStartTime,
                    $lastSevenEndTime,
                    5
                ),
                'data_4' => $this->getGoodsSaleTopList(
                    $lastThirtyStartTime,
                    $lastThirtyEndTime,
                    5
                ),
            ],
            'panel_6' => $this->getUserTopList(10),
        ];
        $data['panel_4']['date'] = [];
        foreach ($data['panel_4']['order_goods_data']['list'] as $item) {
            $data['panel_4']['date'][] = $item['date'];
        }
        return [
            'code' => 0,
            'data' => $data,
        ];
    }

    public function getStoreInfo()
    {
        $common = new CommonStore();
        $storeInfo = $common->storeInfo();

        return $storeInfo;
    }

    /**
     * 获取售罄商品数量
     */
    public function getCountZeroGoodsNum()
    {
        $cache_key = 'zero_goods_nym_' . $this->getCurrentStoreId();
        $count = \Yii::$app->cache->get($cache_key);
        if ($count !== false)
            return $count;
        /** @var Goods[] $goods_list */
        $goods_list = Goods::find()->where([
            'is_delete' => Model::IS_DELETE_FALSE,
            'store_id' => $this->getCurrentStoreId(),
        ])->select('id,attr')->all();
        $count = 0;
        foreach ($goods_list as $goods) {
            if ($goods->getNum() == 0) {
                $count++;
            }
        }
        \Yii::$app->cache->set($cache_key, $count, 60);
        return $count;
    }

    /**
     * 获取待发货订单数
     */
    public function getOrderNoSendCount()
    {
        $common = new CommonOrderStatistics();
        $noSendCount = $common->getOrderNoSendCount();

        return $noSendCount;

    }

    /**
     * 获取售后中订单数
     */
    public function getOrderRefundingCount()
    {
        $common = new CommonOrderStatistics();
        $refundCount = $common->getOrderRefundingCount();

        return $refundCount;
    }

    /**
     * 获取订单商品总数
     * @param null $startTime
     * @param null $endTime
     * @return int
     */
    public function getOrderGoodsCount($startTime = null, $endTime = null)
    {
        $common = new CommonOrderStatistics();
        return $common->getOrderGoodsCount($startTime, $endTime);
    }

    /**
     * 获取订单金额总数（实际付款）
     * @param null $startTime
     * @param null $endTime
     * @return string
     */
    public function getOrderPriceCount($startTime = null, $endTime = null)
    {
        $common = new CommonOrderStatistics();
        $orderPriceCount = $common->getOrderPriceCount($startTime, $endTime);
        return $orderPriceCount;
    }

    /**
     * 获取订单平均消费金额（实际付款）
     * @param null $startTime
     * @param null $endTime
     * @return float|int
     */
    public function getOrderPriceAverage($startTime = null, $endTime = null)
    {
        $common = new CommonOrderStatistics();
        $orderCount = $common->getOrderCount($startTime, $endTime);

        if ($orderCount == 0) {
            return 0;
        }

        $priceCount = $common->getOrderPriceCount($startTime, $endTime);

        $price = $priceCount / $orderCount;
        $price = doubleval(sprintf('%.2f', $price));

        return $price;
    }

    /**
     * 获取n日内每日销量
     */
    public function getDaysOrderGoodsData($days = 7)
    {
        $list = [];
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $start_time = strtotime(date('Y-m-d 00:00:00') . ' -' . $i . ' days');
            $end_time = strtotime(date('Y-m-d 23:59:59') . ' -' . $i . ' days');
            $date = date('m-d', $start_time);
            $val = $this->getOrderGoodsCount($start_time, $end_time);
            $list[] = [
                'date' => $date,
                'val' => $val,
                'start_time' => date('Y-m-d H:i:s', $start_time),
                'end_time' => date('Y-m-d H:i:s', $end_time),
            ];
            $data[] = $val;
        }
        return [
            'list' => array_reverse($list),
            'data' => array_reverse($data),
        ];
    }

    /**
     * 获取n日内每日成交额（已付款）
     */
    public function getDaysOrderGoodsPriceData($days = 7)
    {
        $list = [];
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $start_time = strtotime(date('Y-m-d 00:00:00') . ' -' . $i . ' days');
            $end_time = strtotime(date('Y-m-d 23:59:59') . ' -' . $i . ' days');
            $date = date('m-d', $start_time);
            $val = $this->getOrderPriceCount($start_time, $end_time);
            $list[] = [
                'date' => $date,
                'val' => $val,
                'start_time' => date('Y-m-d H:i:s', $start_time),
                'end_time' => date('Y-m-d H:i:s', $end_time),
            ];
            $data[] = $val;
        }
        return [
            'list' => array_reverse($list),
            'data' => array_reverse($data),
        ];
    }


    /**
     * 获取商品销量排行
     * @param null $startTime
     * @param null $endTime
     * @return mixed
     */
    public function getGoodsSaleTopList($startTime = null, $endTime = null)
    {
        $common = new CommonOrderStatistics();
        $goodsSaleTop = $common->getGoodsSaleTopList($startTime, $endTime);

        return $goodsSaleTop;
    }

    /**
     * 获取用户消费排行列表
     */
    public function getUserTopList($limit = 10)
    {
        $list = Order::find()->alias('o')->leftJoin(['u' => User::tableName()], 'o.user_id=u.id')
            ->where([
                'o.store_id' => $this->getCurrentStoreId(),
                'o.is_pay' => 1,
                'o.is_delete' => 0,
            ])->groupBy('o.user_id')->limit($limit)->orderBy('money DESC')
            ->select('u.id,u.nickname,u.avatar_url AS avatar,SUM(o.pay_price) AS money')
            ->asArray()->all();
        if (!$list)
            return [];
        foreach ($list as $i => $item) {
            $money = doubleval($item['money']);
            if ($money >= 10000) {
                $list[$i]['money'] = number_format($money / 10000, 2, '.', '') . 'w';
            } else {
                $list[$i]['money'] = number_format($money, 2, '.', '');
            }
        }
        return $list;
    }
}