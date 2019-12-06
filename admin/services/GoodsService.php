<?php
namespace app\services;
use app\models\Goods;
use app\models\OrderDetail;

class GoodsService
{


    public function getMchRecommendGoods($mch_id, $count = 3)
    {
        //有设置热销的优先返回设置热销的
        $query = Goods::find()->alias('g')->where([
            'g.is_delete' => 0,
            'g.mch_id' => $mch_id,
            'g.status' => 1,
            'g.hot_cakes' => 1,
        ]);
        $list = $query->select('g.*')
            ->limit($count)
            ->orderBy('g.mch_sort,g.addtime DESC')->asArray()->all();
        if (is_array($list) && count($list))
            return $list;
        //没有热销的按销量排序
        $query = Goods::find()->alias('g')
            ->leftJoin(['od' => OrderDetail::find()->select('goods_id,SUM(num) sale_num')], 'g.id=od.goods_id')
            ->where([
                'g.is_delete' => 0,
                'g.mch_id' => $mch_id,
                'g.status' => 1,
            ]);
        $list = $query->select('g.*')
            ->limit($count)
            ->orderBy('od.sale_num DESC,g.mch_sort,g.addtime DESC')->asArray()->all();
        if (is_array($list) && count($list))
            return $list;
        return [];

    }



}

