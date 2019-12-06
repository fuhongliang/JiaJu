<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/7/25
 * Time: 15:44
 */

namespace app\modules\api\models;


use app\hejiang\ApiCode;
use app\models\Address;
use app\models\DistrictArr;

class AddressSaveForm extends Model
{
    public $store_id;
    public $user_id;
    public $address_id;
    public $name;
    public $mobile;
    public $province_id;
    public $city_id;
    public $district_id;
    public $detail;
    public $is_default;

    public function rules()
    {
        return [
            [['name', 'mobile', 'province_id', 'city_id', 'district_id', 'detail',], 'trim'],
            [['name', 'mobile', 'province_id', 'city_id', 'district_id', 'detail',], 'required'],
            [['address_id',], 'integer'],
            [['mobile'],'match','pattern' =>Model::MOBILE_PATTERN , 'message'=>'手机号错误'],
            [['is_default'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'        => '收货人',
            'mobile'      => '联系电话',
            'province_id' => '所在地区',
            'city_id'     => '所在地区',
            'district_id' => '所在地区',
            'detail'      => '详细地址',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this->errorResponse;
        }
        if (!empty($this->address_id)) {
            $address = Address::findOne(['id' => $this->address_id]);
        }
        if (empty($address)) {
            $address = new Address();
        }
        $address->store_id = $this->store_id;
        $address->user_id = $this->user_id;
        $address->is_delete = Address::DELETE_STATUS_FALSE;
        $is_default = Address::DEFAULT_STATUS_FALSE;
        if (!empty($this->is_default)) {
            $is_default = Address::DEFAULT_STATUS_TRUE;
        }
        $address->is_default = $is_default;
        $address->addtime = time();
        $address->name = $this->name;
        $address->mobile = $this->mobile;
        $address->detail = $this->detail;

        $province = DistrictArr::getDistrict($this->province_id);
        if (!$province) {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '省份数据错误，请重新选择',
            ];
        }
        $address->province_id = $province->id;
        $address->province = $province->name;

        $city = DistrictArr::getDistrict($this->city_id);
        if (!$city) {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '城市数据错误，请重新选择',
            ];
        }
        $address->city_id = $city->id;
        $address->city = $city->name;

        $district = DistrictArr::getDistrict($this->district_id);
        if (!$district) {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '地区数据错误，请重新选择',
            ];
        }
        $address->district_id = $district->id;
        $address->district = $district->name;

        if ($address->save()) {
            $id = $address->id;
            //更新默认地址
            if ($is_default) {
                Address::updateAll(['is_default' => 0],['<>', 'id', $id]);
            }
            return [
                'code' => ApiCode::CODE_SUCCESS,
                'msg'  => '保存成功',
            ];
        } else {
            return [
                'code' => ApiCode::CODE_ERROR,
                'msg'  => '操作失败，请稍后重试',
            ];
        }

    }
}