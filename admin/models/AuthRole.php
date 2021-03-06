<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%auth_role}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthRole extends \yii\db\ActiveRecord
{
    public $checked;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'name'], 'required'],
            [['store_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64],
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
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPermission()
    {
        return $this->hasMany(AuthRolePermission::className(), ['role_id' => 'id']);
    }
}
