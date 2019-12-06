<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 
 * author: wxf
 */

namespace app\models\common\admin\store;

use app\models\Goods;
use app\models\Mch;
use app\models\Model;
use app\models\Order;
use app\models\Store;
use app\models\User;
use app\models\We7Db;
use yii\data\Pagination;
use yii\db\Query;

class CommonStore extends Model
{
    public $page;
    public $limit;
    public $keyword;
    public $is_ind;

    public function rules()
    {
        return [
            [['page'], 'default', 'value' => 1],
            [['limit'], 'default', 'value' => 20],
            [['keyword'], 'trim']
        ];
    }

    public function storeList()
    {
        $query = new Query();
        $query->select('s.*')->from(['s' => Store::tableName()]);
        if (!$this->is_ind) {
            $query->innerJoin(['w' => We7Db::getTableName('account_wxapp')], 'w.uniacid=s.acid');
        } else {
            $query->andWhere(['>', 's.admin_id', 0]);
        }
        if ($this->keyword) {
            $query->andWhere(['like', 's.name', $this->keyword]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit]);
        $list = $query->limit($pagination->limit)->offset($pagination->offset)->all();

        return [
            'list' => $list,
            'pagination' => $pagination
        ];
    }

    public function storeInfo($mchId = 0)
    {
        $goodCount = Goods::find()
            ->where([
                'store_id' => $this->getCurrentStoreId(),
                'is_delete' => Model::IS_DELETE_FALSE,
                'mch_id' => $mchId,
            ])->count();

        $mchCount = Mch::find()
            ->where([
                'store_id' => $this->getCurrentStoreId(),
                'is_delete' => Model::IS_DELETE_FALSE,
                'review_status' => 1,
                'is_lock' => 0,
            ])->count();

        $orderCount = Order::find()->where([
            'store_id' => $this->getCurrentStoreId(),
            'is_delete' => Model::IS_DELETE_FALSE,
            'is_cancel' => Order::IS_CANCEL_FALSE,
            'mch_id' => $mchId,
        ])->andWhere(['or', ['is_pay' => Order::IS_PAY_TRUE], ['pay_type' => Order::PAY_TYPE_COD]])->count();

        $orderTotal = Order::find()->where([
            'store_id' => $this->getCurrentStoreId(),
            'is_delete' => Model::IS_DELETE_FALSE,
            'is_cancel' => Order::IS_CANCEL_FALSE,
        ])->andWhere(['or', ['is_pay' => Order::IS_PAY_TRUE], ['pay_type' => Order::PAY_TYPE_COD]])->count();


        $userCount = User::find()->where([
            'store_id' => $this->getCurrentStoreId(),
            'is_delete' => Model::IS_DELETE_FALSE,
        ])->count();

        return [
            'order_total' => $orderTotal,
            'mch_count' => $mchCount,
            'user_count' => $userCount ? intval($userCount) : 0,
            'goods_count' => $goodCount ? intval($goodCount) : 0,
            'order_count' => $orderCount ? intval($orderCount) : 0,
        ];
    }

}