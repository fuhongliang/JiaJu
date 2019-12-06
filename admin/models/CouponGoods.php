<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%coupon}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $coupon_id
 * @property integer $is_delete
 */
class CouponGoods extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%coupon_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'coupon_id','is_delete'], 'required'],
        ];
    }



}
