<?php

namespace app\models;

use Yii;

class UserMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'topic_id','user_id','contact','telephone','message','created_at'], 'required'],
            [['telephone',], 'string', 'max' => 12],
            [['contact',], 'string', 'max' => 100],
            [['message',], 'string', 'max' => 3000],
            [['is_delete',], 'default', 'value' => 0],
            [['mch_id'],'safe'],
        ];
    }


}
