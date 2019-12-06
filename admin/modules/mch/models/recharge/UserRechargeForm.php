<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/17
 * Time: 9:11
 */

namespace app\modules\mch\models\recharge;

use app\models\IntegralLog;
use app\models\Recharge;
use app\models\ReOrder;
use app\models\User;
use app\modules\mch\models\MchModel;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

class UserRechargeForm extends MchModel
{
    public $store_id;

    public $user_id;

    public $limit;
    public $page;
    public $keyword;

    public function rules()
    {
        return [
            [['limit', 'page'], 'integer'],
            [['limit'], 'default', 'value' => 20],
            [['keyword'], 'trim'],
            [['keyword'], 'string'],
        ];
    }

    public function search()
    {
        if (!$this->validate()) {
            return $this->errorResponse;
        }

        $select = 'id,store_id,user_id, integral as pay_price,addtime as pay_time';
        $ilQuery = (new Query())->from(['il' => IntegralLog::tableName()])
            ->select($select)->andWhere(['type' => 1])
            ->addSelect(new Expression("'后台充值' order_no, '' send_price, '后台充值' pay_type"))
            ->addSelect('pic_url,explain');

        $select = 'id,store_id,user_id, pay_price,pay_time,order_no,send_price,pay_type';
        $roQuery = (new Query())->from(['ro' => ReOrder::tableName()])
            ->select($select)->addSelect(new Expression("'' pic_url, '' `explain`"))
            ->andWhere(['is_pay' => 1, 'is_delete' => 0]);

        $queryTable = $ilQuery->union($roQuery, true);
        $query = (new Query())->from(['qt' => $queryTable])->andWhere(['qt.store_id' => $this->store_id])
            ->leftJoin(['u' => User::tableName()], 'u.id = qt.user_id')->select('u.nickname,qt.*');

        if ($this->user_id) {
            $query->andWhere(['qt.user_id' => $this->user_id]);
        }
        if ($this->keyword) {
            $query->andWhere(['like', 'u.nickname', $this->keyword]);
        }

        $count = $query->count();
        $p = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit]);
        $list = $query->limit($p->limit)->offset($p->offset)->orderBy(['qt.pay_time' => SORT_DESC])->all();

        //充值异常判断  2.2.1.3之前的充值订单可能有问题；
        foreach ($list as $index => $value) {
            $list[$index]['flag'] = 0;
            if ($value['send_price'] != 0) {
                $exists = Recharge::find()->where([
                    'store_id' => $this->store_id, 'pay_price' => $value['pay_price'], 'send_price' => $value['send_price'], 'is_delete' => 0
                ])->exists();
                if (!$exists) {
                    $list[$index]['flag'] = 0;
                }
            }
        }

        return [
            'list' => $list,
            'pagination' => $p,
            'row_count' => $count
        ];
    }
}