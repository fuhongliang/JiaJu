<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/8/3
 * Time: 13:52
 */

namespace app\modules\mch\models;


use app\models\Level;
use app\models\Order;
use app\models\UserCoupon;
use app\models\Shop;
use app\models\Store;
use app\models\User;
use app\models\UserCard;
use yii\data\Pagination;

class UserListForm extends MchModel
{
    public $store_id;
    public $page;
    public $keyword;
    public $is_clerk;
    public $level;

    public function rules()
    {
        return [
            [['keyword', 'level'], 'trim'],
            [['page', 'is_clerk'], 'integer'],
            [['page'], 'default', 'value' => 1],
        ];
    }

    public function search()
    {
        $query = User::find()->alias('u')->where([
            'u.type' => 1,
            'u.store_id' => $this->store_id,
            'u.is_delete' => 0,
        ])->leftJoin(Shop::tableName() . ' s', 's.id=u.shop_id')
            ->leftJoin(Level::tableName() . ' l', 'l.level=u.level and l.store_id=' . $this->store_id)
            ->andWhere(['OR', [
                'l.is_delete' => 0], 'l.id IS NULL']);
        if ($this->keyword)
            $query->andWhere(['LIKE', 'u.nickname', $this->keyword]);
        if ($this->is_clerk == 1) {
            $query->andWhere(['u.is_clerk' => 1]);
            $orderQuery = Order::find()->where(['store_id' => $this->store_id, 'is_delete' => 0, 'is_cancel' => 0, 'is_recycle' => 0, 'mch_id' => 0])->andWhere('clerk_id = u.id')->select('count(1)');
            $cardQuery = UserCard::find()->where(['store_id' => $this->store_id, 'is_delete' => 0])->andWhere('clerk_id = u.id')->select('count(1)');
        } else {
            $orderQuery = Order::find()->where(['store_id' => $this->store_id, 'is_delete' => 0, 'is_cancel' => 0, 'is_recycle' => 0, 'mch_id' => 0])->andWhere('user_id = u.id')->select('count(1)');
            $cardQuery = UserCard::find()->where(['store_id' => $this->store_id, 'is_delete' => 0])->andWhere('user_id = u.id')->select('count(1)');
        }
        if ($this->level) {
            $query->andWhere(['l.level' => $this->level]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1]);
        $couponQuery = UserCoupon::find()->where(['is_delete' => 0])->andWhere('user_id = u.id')->select('count(1)');
        $list = $query->select([
            'u.*', 's.name shop_name', 'l.name l_name', 'card_count' => $cardQuery, 'order_count' => $orderQuery, 'coupon_count' => $couponQuery
        ])->limit($pagination->limit)->offset($pagination->offset)->orderBy('u.addtime DESC')->asArray()->all();
        return [
            'row_count' => $count,
            'page_count' => $pagination->pageCount,
            'pagination' => $pagination,
            'list' => $list,
        ];
    }

    public function getUser()
    {
        $query = User::find()->where([
            'type' => 1,
            'store_id' => $this->store_id,
            'is_clerk' => 0,
            'is_delete' => 0
        ]);
        if ($this->keyword)
            $query->andWhere(['LIKE', 'nickname', $this->keyword]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1]);
        $list = $query->limit($pagination->limit)->offset($pagination->offset)->orderBy('addtime DESC')->asArray()->all();
//        $list = $query->orderBy('addtime DESC')->asArray()->all();

        return $list;
    }
}