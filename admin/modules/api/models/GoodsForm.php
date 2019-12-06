<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/8/15
 * Time: 9:56
 */

namespace app\modules\api\models;

use app\extensions\GetInfo;
use app\hejiang\ApiResponse;
use app\models\Favorite;
use app\models\Goods;
use app\models\GoodsPic;
use app\models\Mch;
use app\models\MiaoshaGoods;
use app\modules\api\controllers\mch\ShopDataForm;
use app\models\Coupon;
use app\models\UserCoupon;

class GoodsForm extends Model
{
    public $id;
    public $user_id;
    public $store_id;

    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id'], 'safe'],
        ];
    }

    /**
     * 排序类型$sort   1--综合排序 2--销量排序
     */
    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $goods = Goods::findOne([
            'id' => $this->id,
            'is_delete' => 0,
            'status' => 1,
            'store_id' => $this->store_id,
        ]);
        if (!$goods)
            return new ApiResponse(1,'商品不存在或已下架');
        $mch = null;
        if ($goods->mch_id) {
            $mch = $this->getMch($goods);
            if (!$mch)
                return new ApiResponse(1,'店铺已经打烊了哦~');
        }
        $pic_list = GoodsPic::find()->select('pic_url')->where(['goods_id' => $goods->id, 'is_delete' => 0])->asArray()->all();
        $is_favorite = 0;
        if ($this->user_id) {
            $exist_favorite = Favorite::find()->where(['user_id' => $this->user_id, 'goods_id' => $goods->id, 'is_delete' => 0])->exists();
            if ($exist_favorite)
                $is_favorite = 1;
        }
        $service_list = explode(',', $goods->service);
        $new_service_list = [];
        if (is_array($service_list))
            foreach ($service_list as $item) {
                $item = trim($item);
                if ($item)
                    $new_service_list[] = $item;
            }
        $res_url = GetInfo::getVideoInfo($goods->video_url);
        $goods->video_url = $res_url['url'];

        //优惠券列表
        $query = Coupon::find()->alias('c')->where([
            'c.is_delete' => 0, 'c.store_id' => $this->store_id, 'c.appoint_type' => 3
        ]);
        $user_id = 0;
        if (!empty($this->user_id)) {
            $user_id = $this->user_id;
        }
        $coupon_list = $query->andWhere(['!=', 'c.total_count', 0])
            ->leftJoin(UserCoupon::tableName() . ' uc', "uc.coupon_id=c.id and uc.user_id ={$user_id} and uc.type = 2 and uc.is_delete=0")->select([
                'c.*', '(case when isnull(uc.id) then 0 else 1 end) as is_receive'
            ])->orderBy('is_receive ASC,sort ASC')->asArray()->all();
        $new_list = [];
        $coupon_title = [];
        foreach($coupon_list as $index=>$value){
            if (count($coupon_title) != 2) {
                $coupon_title[] = $value['name'];
            }
            if($value['min_price'] >= 100){
                $coupon_list[$index]['min_price'] = strval($value['min_price']);
            }
            if($value['sub_price'] >= 100){
                $coupon_list[$index]['sub_price'] = strval($value['sub_price']);
            }
            $coupon_list[$index]['begintime'] = date('Y.m.d',$value['begin_time']);
            $coupon_list[$index]['endtime'] = date('Y.m.d',$value['end_time']);
            $coupon_list[$index]['show_time'] = date('Y.m.d',$value['begin_time']).'-'. date('Y.m.d',$value['end_time']).'有效';
            $coupon_list[$index]['content'] = "全场商品通用";

            if($value['appoint_type'] == 2){
                $coupon_list[$index]['goods'] = Goods::find()->select('id')->where(['store_id'=>$this->store_id,'is_delete'=>0,'id'=>json_decode($value['goods_id_list'])])->asArray()->all();
                $coupon_list[$index]['cat'] = [];
                $coupon_list[$index]['content'] = "指定商品使用";
            }else{
                $coupon_list[$index]['goods'] = [];
                $coupon_list[$index]['cat'] = [];
                $coupon_list[$index]['content'] = '全场商品通用';
            }
            $coupon_count = UserCoupon::find()->where([
                'store_id'=>$this->store_id,'is_delete'=>0,'coupon_id'=>$value['id'],'type'=>2
            ])->count();
            if($value['total_count'] > $coupon_count || $value['total_count'] == -1){
                if($value['expire_type'] == 2){
                    if($value['end_time'] >= time()){
                        $new_list[] = $coupon_list[$index];
                    }
                }else{
                    $new_list[] = $coupon_list[$index];
                }
            }
        }

        $data = [
            'coupon_title' => $coupon_title,
            'coupon_list' => $new_list,
            'id' => $goods->id,
            'pic_list' => $pic_list,
            'attr'=>$goods->attr,
            'name' => $goods->name,
            'cat_id' => $goods->cat_id,
            'price' => strval($goods->price),
            'detail' => $goods->detail,
            'sales_volume' => $goods->getSalesVolume() + $goods->virtual_sales,
            'attr_group_list' => $goods->getAttrGroupList(),
            'num' => $goods->getNum(),
            'is_favorite' => $is_favorite,
            'service_list' => $new_service_list,
            'original_price' => floatval($goods->original_price),
            'video_url' => $goods->video_url,
            'unit' => $goods->unit,
//                'miaosha' => $this->getMiaoshaData($goods->id),
            'use_attr' => intval($goods->use_attr),
            'mch' => $mch,
            'show_integral' => intval($goods->show_integral),
        ];
        return new ApiResponse(0,'success',$data);
    }

    //获取商品秒杀数据
    public function getMiaoshaData($goods_id)
    {
        $miaosha_goods = MiaoshaGoods::findOne([
            'goods_id' => $goods_id,
            'is_delete' => 0,
            'start_time' => intval(date('H')),
            'open_date' => date('Y-m-d'),
        ]);
        if (!$miaosha_goods)
            return null;
        $attr_data = json_decode($miaosha_goods->attr, true);
        $total_miaosha_num = 0;
        $total_sell_num = 0;
        $miaosha_price = 0.00;
        foreach ($attr_data as $i => $attr_data_item) {
            $total_miaosha_num += $attr_data_item['miaosha_num'];
            $total_sell_num += $attr_data_item['sell_num'];
            if ($miaosha_price == 0) {
                $miaosha_price = $attr_data_item['miaosha_price'];
            } else {
                $miaosha_price = min($miaosha_price, $attr_data_item['miaosha_price']);
            }
        }
        return [
            'miaosha_num' => $total_miaosha_num,
            'sell_num' => $total_sell_num,
            'miaosha_price' => (float)$miaosha_price,
            'begin_time' => strtotime($miaosha_goods->open_date . ' ' . $miaosha_goods->start_time . ':00:00'),
            'end_time' => strtotime($miaosha_goods->open_date . ' ' . $miaosha_goods->start_time . ':59:59'),
            'now_time' => time(),
        ];
    }


    // 快速给购买商品
    public function quickGoods($twocatid)
    {
        $goods = Goods::find()
            ->where([
                'store_id' => $this->store_id,
                'is_delete' => 0,
                'status' => 1,
                'quick_purchase' => 1
            ])
            ->andWhere([

                'in', 'cat_id', $twocatid
            ])->asArray()
            ->all();
        foreach ($goods as $key => &$value) {
            $value['attr'] = json_decode($value['attr']);
            foreach ($value['attr'] as $key2 => $value2) {
                foreach ($value2->attr_list as $key3 => $value3) {
                    $value['attr_name'] = $value3->attr_name;
                }
                // $value['attr_num'][] = $value2->num;
                // $value['attr_price'][] = $value2->price;
                // $value['attr_no'][] = $value2->no;
                // $value['attr_pic'][] = $value2->pic;
                $value['num'] = 0;
            }
            // unset($value['attr']);
        }
        return [
            'code' => 0,
            'data' => [
                'list' => $goods,
            ],
        ];
    }

    /**
     * @param Goods $goods
     */
    public function getMch($goods)
    {
        $f = new ShopDataForm();
        $f->mch_id = $goods->mch_id;
        $shop = $f->getShop();
        if (isset($shop['code']) && $shop['code'] == 1)
            return null;
        return $shop;
    }
}
