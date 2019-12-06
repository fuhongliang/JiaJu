<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string  $name
 * @property integer $level
 * @property integer $is_delete
 * @property integer $addtime
 * @property integer $sort
 * @property integer $is_open
 * @property integer $postage
 */
class AgentDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_district}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'district_id'], 'integer'],
            [['is_delete'], 'safe']
        ];
    }

}
