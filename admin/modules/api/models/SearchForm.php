<?php
/**
 * Created by PhpStorm.
 * User: 风哀伤
 * Date: 2018/6/28
 * Time: 15:20
 */

namespace app\modules\api\models;


use app\hejiang\ApiResponse;
use app\models\Goods;
use app\models\MiaoshaGoods;
use app\models\MsGoods;
use app\models\PtGoods;
use app\models\YyGoods;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

class SearchForm extends Model
{
    public $store_id;

    public $limit;
    public $page;

    public $keyword;

    public function rules()
    {
        return [
            [['limit', 'page'], 'integer'],
            [['limit'], 'default', 'value' => 20],
            [['keyword'], 'trim'],
            [['keyword'], 'string']
        ];
    }

    public function search()
    {
        if (!$this->validate()) {
            return $this->errorResponse;
        }
        $select = ['id', 'name', 'sort', 'addtime', 'price', 'cover_pic pic_url', 'store_id', 'status', 'is_delete'];
        $query_m = (new Query())->from([Goods::tableName()])
            ->select($select)->addSelect(new Expression("'m' goods_type"));
        $query_pt = (new Query())->from([PtGoods::tableName()])
            ->select($select)->addSelect(new Expression("'pt' goods_type"));
        $query_yy = (new Query())->from([YyGoods::tableName()])
            ->select($select)->addSelect(new Expression("'yy' goods_type"));
        $query_ms = (new Query())->from(['ms' => MsGoods::tableName()])->innerJoin(['mg' => MiaoshaGoods::tableName()], 'mg.goods_id=ms.id')
            ->where([
                'mg.open_date' => date('Y-m-d'),
                'mg.start_time' => date('H'),
                'mg.is_delete' => 0
            ])->select(['mg.id', 'ms.name', 'ms.sort', 'ms.addtime', 'ms.original_price price', 'ms.cover_pic pic_url', 'ms.store_id', 'ms.status', 'ms.is_delete'])
            ->addSelect(new Expression("'ms' goods_type"));
        $query_table = $query_m->union($query_pt, true)->union($query_yy, true)->union($query_ms, true);
        $query = (new Query())->from(['g' => $query_table])->andWhere(['g.status' => 1, 'g.is_delete' => 0]);
        if ($this->store_id)
            $query->andWhere(['g.store_id' => $this->store_id]);

        if ($this->keyword)
            $query->andWhere(['LIKE', 'g.name', $this->keyword]);
        $count = $query->count(1);

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit, 'page' => $this->page - 1]);
        //综合，自定义排序+时间最新
        $query->orderBy('g.sort ASC, g.addtime DESC');

        $list = $query
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->groupBy('g.goods_type,g.id')->all();

        foreach ($list as $i => $item) {
            switch ($item['goods_type']) {
                case 'm':
                    $list[$i]['url'] = "/pages/goods/goods?id=" . $item['id'];
                    break;
                case 'pt':
                    $list[$i]['url'] = "/pages/pt/details/details?gid=" . $item['id'];
                    break;
                case 'yy':
                    $list[$i]['url'] = "/pages/book/details/details?id=" . $item['id'];
                    break;
                case 'ms':
                    $list[$i]['url'] = "/pages/miaosha/details/details?id=" . $item['id'];
                    break;
                default:
                    $list[$i]['url'] = "/pages/goods/goods?id=" . $item['id'];
                    break;
            }
        }
        $data = [
            'row_count' => $count,
            'page_count' => $pagination->pageCount,
            'list' => $list,
        ];
        return new ApiResponse(0, 'success', $data);

    }
}