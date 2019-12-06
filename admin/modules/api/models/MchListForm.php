<?php
namespace app\modules\api\models;
use app\models\Cat;
use app\models\District;
use app\models\Goods;
use app\models\Mch;
use app\models\Order;
use app\services\GoodsService;
use yii\data\Pagination;
use app\hejiang\ApiResponse;
use yii\db\Query;

class MchListForm extends Model
{
    public $cat_id;
    public $page=1;
    public $limit = 20;
    public $store_id;
    public $sort=1;
    public $district;

    public function rules()
    {
        return [
            ['cat_id', 'required'],
            ['page', 'default', 'value' => 1,],
            ['sort', 'default', 'value' => 1,],
            [['district'],'safe']
        ];
    }


    public function search()
    {
        //找父级分类
        $districtInfo = District::find()->where(['name'=> $this->district])->asArray()->one();

        $sub_sql = "select * from ".Cat::tableName().
            " where store_id = ".$this->store_id." and id=".$this->cat_id;
        $sub = \Yii::$app->db->createCommand($sub_sql)->queryOne();
        if (!empty($sub)) {
            $parent_sql = "select * from ".Cat::tableName().
                " where store_id = ".$this->store_id." and id=".$sub['parent_id'];
            $parent = \Yii::$app->db->createCommand($parent_sql)->queryOne();
        }
        if (!empty($parent)) {
            $parent_id = $parent['id'];
        }
        if ($this->sort == 1) { //按最新
            $query = (new Query())
                ->select('*')
                ->from(Mch::tableName() . " as mch")
                ->where([
                    'mch.store_id' => $this->store_id,
                    'mch.is_delete' => 0,
                    'mch.district_id' => $districtInfo['id'],
                    ]);
            if (!empty($parent_id)) {
                $query = $query->andwhere(['or' , ['=' , 'mch.mch_common_cat_id' , $this->cat_id] , ['=' , 'mch.mch_common_cat_id' , $parent_id]]);
            } else {
                $query = $query->andwhere(['mch.mch_common_cat_id' => $this->cat_id]);
            }
            $query = $query->orderBy('mch.addtime DESC');
        } else {
            $query = (new Query())
                ->select('mch.*,
                (SELECT count(o.id) as count FROM '.Order::tableName().' AS o where o.mch_id =mch.id) as ordercount')
                ->from(Mch::tableName() . " as mch")
                ->where([
                    'mch.store_id' => $this->store_id,
                    'mch.is_delete' => 0,
                    'mch.district_id' => $districtInfo['id'],
                    ]);
            if (!empty($parent_id)) {
                $query = $query->andwhere(['or' , ['=' , 'mch.mch_common_cat_id' , $this->cat_id] , ['=' , 'mch.mch_common_cat_id' , $parent_id]]);
            } else {
                $query = $query->andwhere(['mch.mch_common_cat_id' => $this->cat_id]);
            }
            $query = $query->orderBy('ordercount DESC');
        }

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->limit($pagination->limit)->offset($pagination->offset)->all();

        $mch_list = [];
        foreach ($list as $i => $item) {
            //获取商品数
            $mch_id = $item['id'];
            $goods_count = Goods::find()->where(['mch_id' => $mch_id,'is_delete' => 0,'status' => 1])->count();

            //获取三个商品
            $goods_list =(new GoodsService())->getMchRecommendGoods($mch_id, 3);
            $mch['id'] = $item['id'];
            $mch['mch_color'] = $item['mch_color'];
            $mch['header_bg'] = $item['header_bg'];
            $mch['mch_name'] = $item['name'];
            $mch['logo'] = $item['logo'];
            $mch['goods_list'] = $goods_list;
            $mch['goods_count'] = $goods_count;
            $mch_list[] = $mch;
        }
        $data = [
            'page' => $this->page,
            'row_count' => $count,
            'page_count' => $pagination->pageCount,
            'list' => $mch_list,
        ];
        return new ApiResponse(0,'success',$data);

    }









}
