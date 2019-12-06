<?php

namespace app\modules\mch\controllers\mch;

use app\models\AgentDistrict;
use app\models\Cat;
use app\models\Goods;
use app\models\GoodsCat;
use app\models\Mch;
use app\modules\mch\controllers\Controller;
use Yii;
use yii\data\Pagination;

class GoodsController extends Controller
{

    public function actionGoods()
    {
        $query_cat = GoodsCat::find()->alias('gc')->leftJoin(['c' => Cat::tableName()], 'c.id=gc.cat_id')
            ->where(['gc.store_id' => $this->store->id, 'gc.is_delete' => 0])->select('gc.goods_id,c.name,gc.cat_id');

        $query = Goods::find()->alias('g')
            ->where(['g.store_id' => $this->store->id, 'g.is_delete' => 0]);
        $query->andWhere(['>', 'g.mch_id', 0]);

        // 是否是代理登录
        if (Yii::$app->mchRoleAdmin->identity->is_agent) {
            $query->innerJoin(['m' => Mch::tableName()], 'm.id=g.mch_id')
            ->innerJoin(['d' => AgentDistrict::tableName()], 'd.district_id=m.district_id')
                ->andWhere(['d.user_id'=>Yii::$app->mchRoleAdmin->identity->id]);
        }
        if ($status != null) {
            $query->andWhere('g.status=:status', [':status' => $status]);
        }
        $query->leftJoin(['c' => Cat::tableName()], 'c.id=g.cat_id');
        $query->leftJoin(['gc' => $query_cat], 'gc.goods_id=g.id');

        $cat_query = clone $query;

        $select = 'g.id,g.name,g.price,g.original_price,g.index_recommend,
        g.status,g.cover_pic,g.sort,g.attr,g.cat_id,g.virtual_sales,g.store_id,g.quick_purchase,g.mch_id';
        $query->select($select);
        if (trim($keyword)) {
            $query->andWhere(['LIKE', 'g.name', $keyword]);
        }
        if (isset($_GET['cat'])) {
            $cat = trim($_GET['cat']);
            $query->andWhere([
                'or',
                ['c.name' => $cat],
                ['gc.name' => $cat],
            ]);
        }
        $cat_list = $cat_query->groupBy('name')->orderBy(['g.cat_id' => SORT_ASC])->select([
            '(case when g.cat_id=0 then gc.name else c.name end) name',
        ])->asArray()->column();
        $query->groupBy('g.id');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $list = $query->orderBy('g.sort ASC,g.addtime DESC')
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->with(['goodsPicList', 'catList1.cat', 'cat'])
            ->all();

        return $this->render('goods', [
            'list' => $list,
            'pagination' => $pagination,
            'cat_list' => $cat_list,
        ]);
    }


    public function actionGoodsIndexRecommend($id = 0)
    {
        $goods = Goods::findOne(['id' => $id, 'is_delete' => 0, 'store_id' => $this->store->id]);
        if (!$goods) {
            return [
                'code' => 1,
                'msg' => '商品不存在或已删除',
            ];
        }
        $goods->index_recommend = 1;
        if ($goods->save()) {
            return [
                'code' => 0,
                'msg' => '成功',
            ];
        } else {
            foreach ($goods->errors as $errors) {
                return [
                    'code' => 1,
                    'msg' => $errors[0],
                ];
            }
        }
    }


    public function actionCancelIndexRecommend($id = 0)
    {
        $goods = Goods::findOne(['id' => $id, 'is_delete' => 0, 'store_id' => $this->store->id]);
        if (!$goods) {
            return [
                'code' => 1,
                'msg' => '商品不存在或已删除',
            ];
        }
        $goods->index_recommend = 0;
        if ($goods->save()) {
            return [
                'code' => 0,
                'msg' => '成功',
            ];
        } else {
            foreach ($goods->errors as $errors) {
                return [
                    'code' => 1,
                    'msg' => $errors[0],
                ];
            }
        }
    }


}
