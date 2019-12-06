<?php

namespace app\models;

use Yii;

/**
 *   `price` varchar(128) not null default '' comment '额度',
`image_url` varchar(512) not null default '' comment '转账图片',
`store_id` int(11) unsigned not null default 0 comment '平台id',
`mch_id` int(11) unsigned not null default 0 comment '商家id',
`created_at` int(11) unsigned not null default 0 comment '创建时间',
`is_delete` tinyint(4) unsigned not null default 0 comment '是否已删除',
`status` tinyint(4) unsigned not null default 0 comment '1为已审核',
 *
 * Class MchDeposit
 * @package app\models
 */
class MchDeposit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mch_deposit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'store_id', 'mch_id'], 'required'],
        ];
    }



}
