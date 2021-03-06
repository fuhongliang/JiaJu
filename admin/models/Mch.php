<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%mch}}".
 *
 * @property string $id
 * @property integer $store_id
 * @property integer $user_id
 * @property integer $addtime
 * @property integer $is_delete
 * @property integer $is_open
 * @property integer $is_lock
 * @property integer $review_status
 * @property string $review_result
 * @property integer $review_time
 * @property string $realname
 * @property string $tel
 * @property string $name
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $address
 * @property integer $mch_common_cat_id
 * @property string $service_tel
 * @property string $logo
 * @property string $header_bg
 * @property integer $transfer_rate
 * @property string $account_money
 * @property integer $sort
 * @property string $auth_key
 * @property string username
 * @property string password
 * @property string access_token
 */
class Mch extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mch}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header_color','mch_color','longitude','latitude','store_id', 'user_id', 'realname', 'tel', 'name', 'province', 'city', 'district', 'address', 'mch_common_cat_id', 'service_tel','password', 'username'], 'required'],
            [['content_permission','store_id', 'user_id', 'addtime', 'is_delete', 'is_open', 'is_lock', 'review_status', 'review_time', 'province_id', 'city_id', 'district_id', 'mch_common_cat_id', 'transfer_rate', 'sort'], 'integer'],
            [['review_result', 'logo', 'header_bg'], 'string'],
            [['account_money'], 'number'],
            [['realname', 'tel', 'name'], 'string', 'max' => 255],
            [['address', 'service_tel'], 'string', 'max' => 1000],
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
            'user_id' => 'User ID',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
            'is_open' => '是否营业：0=否，1=是',
            'is_lock' => '是否被系统关闭：0=否，1=是',
            'review_status' => '审核状态：0=待审核，1=审核通过，2=审核不通过',
            'review_result' => '审核结果',
            'review_time' => '审核时间',
            'realname' => 'Realname',
            'tel' => 'Tel',
            'name' => 'Name',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'district_id' => 'District ID',
            'address' => 'Address',
            'mch_common_cat_id' => '所售类目',
            'service_tel' => '客服电话',
            'logo' => 'logo',
            'header_bg' => '背景图',
            'transfer_rate' => '商户手续费',
            'account_money' => '商户余额',
            'sort' => '排序：升序',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne([
            'access_token' => $token,
        ]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}
