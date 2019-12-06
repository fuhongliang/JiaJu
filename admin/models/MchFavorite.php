<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mch_favorite}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $user_id
 * @property integer $mch_id
 * @property integer $created_at
 * @property integer $is_delete
 */
class MchFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mch_favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'user_id', 'mch_id', 'created_at'], 'required'],
            [['store_id', 'user_id', 'mch_id', 'created_at', 'is_delete'], 'integer'],
        ];
    }

}
