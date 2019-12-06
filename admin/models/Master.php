<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%master}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $job
 * @property string $advantage
 * @property string $info
 * @property integer $addtime
 * @property string $mobile
 * @property integer $sort
 */
class Master extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id'], 'required'],
            [['store_id', 'addtime', 'sort'], 'integer'],
            [['info'], 'string'],
            [['name', 'cover_pic','job','advantage','mobile','year'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'cover_pic' => '封面图片',
            'name' => '姓名',
            'job' => '职业',
            'advantage' => '特性',
            'info' => '个人简介',
            'mobile' => '手机',
            'sort' => '排序：升序',
            'addtime' => 'Addtime',
            'year' => '工龄',
        ];
    }
}
