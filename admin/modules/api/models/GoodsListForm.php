<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/7/1
 * Time: 23:33
 */

namespace app\modules\api\models;


use app\hejiang\ApiResponse;
use app\models\Cat;
use app\models\District;
use app\models\Goods;
use app\models\GoodsBanner;
use app\models\GoodsCat;
use app\models\GoodsPic;
use app\models\Mch;
use app\models\Order;
use app\models\OrderDetail;
use yii\data\Pagination;

class GoodsListForm extends Model
{
    public $store_id;
    public $keyword;
    public $cat_id;
    public $page;
    public $limit;

    public $sort;
    public $sort_type;

    public $goods_id;
    public $pic_url;
    public $recommend_count;
    public $district;


    public function rules()
    {
        return [
            [['keyword'], 'trim'],
            [['store_id', 'cat_id', 'page', 'limit',], 'integer'],
            [['limit'], 'integer',],
            [['limit',], 'default', 'value' => 12],
            [['sort', 'sort_type', 'recommend_count'], 'integer',],
            [['sort',], 'default', 'value' => 0],
            [['goods_id',], 'string'],
            [['district'], 'safe']
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $districtInfo = District::find()->where(['name'=> $this->district])->asArray()->one();
        if (!empty($districtInfo['id'])) {
            $query = Goods::find()->alias('g')->innerJoin(['m' => Mch::tableName()], 'm.id=g.mch_id')
                ->where([
                    'm.district_id' => $districtInfo['id'],
                    'g.status' => 1,
                    'g.is_delete' => 0,
                    ]);
        } else {
            $query = Goods::find()->alias('g')->where([
                'g.status' => 1,
                'g.is_delete' => 0,
            ]);
        }
        if ($this->store_id)
            $query->andWhere(['g.store_id' => $this->store_id]);
        if ($this->cat_id) {
            $cat = Cat::find()->select('id')->where(['is_delete' => 0,])->andWhere(['OR', ['parent_id' => $this->cat_id], ['id' => $this->cat_id],]);
            $gc_query = GoodsCat::find()->where(['cat_id' => $cat]);

            $query->leftJoin(['gc' => $gc_query], 'gc.goods_id=g.id and gc.is_delete = 0');
            $query->andWhere(
                [
                    'OR',
                    ['g.cat_id' => $this->cat_id],
                    ['g.cat_id' => $cat],
                    ['gc.cat_id' => $this->cat_id],
                    ['gc.cat_id' => $cat],
                ]
            );
        }

        if ($this->goods_id) {
            $arr = explode(',', $this->goods_id);
            $query->andWhere(['in', 'id', $arr]);
        }
        if ($this->keyword)
            $query->andWhere(['LIKE', 'g.name', $this->keyword]);
        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit, 'page' => $this->page - 1]);
        if ($this->sort == 0) {
            //综合，自定义排序+时间最新
            $query->orderBy('g.sort ASC, g.addtime DESC');
        }
        if ($this->sort == 1) {
            //时间最新
            $query->orderBy('g.addtime DESC');
        }
        if ($this->sort == 2) {
            //价格
            if ($this->sort_type == 0) {
                $query->orderBy('g.price ASC');
            } else {
                $query->orderBy('g.price DESC');
            }
        }
        if ($this->sort == 3) {
            //销量
            $query->orderBy([
                '( IF(gn.num, gn.num, 0) + virtual_sales)' => SORT_DESC,
                'g.addtime' => SORT_DESC,
            ]);
        }

        $od_query = OrderDetail::find()->alias('od')
            ->leftJoin(['o' => Order::tableName()], 'od.order_id=o.id')
            ->where(['od.is_delete' => 0, 'o.store_id' => $this->store_id, 'o.is_pay' => 1, 'o.is_delete' => 0])->groupBy('od.goods_id')->select('SUM(od.num) num,od.goods_id');

        $list = $query
            ->leftJoin(['gn' => $od_query], 'gn.goods_id=g.id')
            ->select('g.id,g.name,g.price,g.original_price,g.cover_pic pic_url,gn.num,g.virtual_sales,g.unit,g.show_integral')
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->asArray()->groupBy('g.id')->all();

        foreach ($list as $i => $item) {
            if (!$item['pic_url']) {
                $list[$i]['pic_url'] = Goods::getGoodsPicStatic($item['id'])->pic_url;
            }
            $list[$i]['sales'] = $this->numToW($item['num'] + $item['virtual_sales']) . $item['unit'];
        }
        //商品列表轮播图
        $banner_list = GoodsBanner::find()->where(['store_id'=>$this->store_id,'is_delete'=>0])
            ->orderBy('sort ASC')->asArray()->all();
        $data = [
            'row_count' => $count,
            'page_count' => $pagination->pageCount,
            'list' => $list,
            'banner_list'=>$banner_list
        ];
        return new ApiResponse(0, 'success', $data);
    }

    public function recommend()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $goods_id = $this->goods_id;
        if (!$goods_id) {
            return new ApiResponse(1, 'error');
        }
        $cat_ids = [];

        $goods = Goods::find()->select('*')->where(['store_id' => $this->store_id, 'is_delete' => 0])->andWhere('id=:id', [':id' => $goods_id])->one();
        $cat_id = $goods->cat_id;

        if ($cat_id == 0) {
            $goodsCat = GoodsCat::find()->select('cat_id')->where(['store_id' => $this->store_id, 'goods_id' => $goods_id, 'is_delete' => 0])->all();
            $goods_cat = [];
            foreach ($goodsCat as $v) {
                $goods_cat[] = $v->cat_id;
            }
        } else {
            $goods_cat = array(intval($cat_id));
        }
        $cat_ids = $goods_cat;
        $goodscat_list = GoodsCat::find()->select(['goods_id'])->where(['store_id' => $this->store_id, 'is_delete' => 0])->andWhere(['in', 'cat_id', $cat_ids])->all();

        $cats = [];
        foreach ($goodscat_list as $v) {
            $cats[] = $v->goods_id;
        }

        $query = Goods::find()->alias('g')
            ->where(['and', "g.id!=$goods_id", 'cat_id=0', "store_id=$this->store_id", 'is_delete=0', 'status=1', ['in', 'id', $cats]])
            ->orWhere(['and', "g.id!=$goods_id", "store_id=$this->store_id", 'is_delete=0', 'status=1', ['in', 'cat_id', $cat_ids]]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit, 'page' => $this->page - 1]);

        $query->orderBy('g.sort ASC');

        $od_query = OrderDetail::find()->alias('od')
            ->leftJoin(['o' => Order::tableName()], 'od.order_id=o.id')
            ->where(['od.is_delete' => 0, 'o.store_id' => $this->store_id, 'o.is_pay' => 1, 'o.is_delete' => 0])->groupBy('od.goods_id')->select('SUM(od.num) num,od.goods_id');


        $limit = $pagination->limit;
        $offset = $pagination->offset;
        $recommend_count = $this->recommend_count;
        if ($offset > $recommend_count) {
            return new ApiResponse(1, 'error');
        } else if ($offset + $limit > $recommend_count) {
            $limit = $recommend_count - $offset;
        }

        $list = $query
            ->leftJoin(['gn' => $od_query], 'gn.goods_id=g.id')
            ->select('g.id,g.name,g.price,g.original_price,g.cover_pic pic_url,gn.num,g.virtual_sales,g.unit')
            ->limit($limit)
            ->offset($pagination->offset)
            ->asArray()->groupBy('g.id')->all();

        foreach ($list as $i => $item) {
            if (!$item['pic_url']) {
                $list[$i]['pic_url'] = Goods::getGoodsPicStatic($item['id'])->pic_url;
            }
            $list[$i]['sales'] = $this->numToW($item['num'] + $item['virtual_sales']) . $item['unit'];

        }
        $data = [
            'row_count' => $count,
            'page_count' => $pagination->pageCount,
            'list' => $list,
        ];
        return new ApiResponse(0, 'success', $data);
    }

    private function numToW($sales)
    {
        if ($sales < 10000) {
            return $sales;
        } else {
            return round($sales / 10000, 2) . 'W';
        }
    }

    public function couponSearch()
    {
//        ,'name','price','original_price','pic_url','num','virtual_sales','unit'
        $arr = explode(",", $this->goods_id);

        $query = Goods::find()->where(['store_id' => $this->store_id, 'is_delete' => 0, 'status' => 1])->andWhere(['in', 'id', $arr]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit, 'page' => $this->page - 1]);

        if ($this->sort == 0) {
            //综合，自定义排序+时间最新
            $query->orderBy('sort ASC,addtime DESC');
        }
        if ($this->sort == 1) {
            //时间最新
            $query->orderBy('addtime DESC');
        }
        if ($this->sort == 2) {
            //价格
            if ($this->sort_type == 0) {
                $query->orderBy('price ASC');
            } else {
                $query->orderBy('price DESC');
            }
        }
        if ($this->sort == 3) {
            //销量
            $query->orderBy([
                'virtual_sales' => SORT_DESC,
                'addtime' => SORT_DESC,
            ]);
        }
        $list = $query
            ->select(['id', 'name', 'cover_pic as pic_url', 'price', 'original_price', 'virtual_sales as sales', 'unit'])
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->asArray()->all();
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'row_count' => $count,
                'page_count' => $pagination->pageCount,
                'list' => $list,
            ],
        ];
    }

}
