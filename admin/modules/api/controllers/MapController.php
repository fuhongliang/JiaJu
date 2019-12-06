<?php

namespace app\modules\api\controllers;

use app\hejiang\ApiResponse;
use app\hejiang\BaseApiResponse;
use app\models\District;
use Curl\Curl;
use Yii;

class MapController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
        ]);
    }



    public function actionGetCityName()
    {
        $data = Yii::$app->request->get();
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $key = 'QPWBZ-SV43F-XDWJH-NMHYD-HCCDT-TTF6H';
        $api = "https://apis.map.qq.com/ws/geocoder/v1/?location={$latitude},{$longitude}&key={$key}&get_poi=1";
        $curl = new Curl();
        $curl->get($api);
        $res = json_decode($curl->response, true);
        $city = '';
        $district = '';
        if (!empty($res['result']['address_component'])) {
            $city = $res['result']['address_component']['city'];
            $district = $res['result']['address_component']['district'];
        }
        $return['city'] = $city;
        $return['district'] = $district;
        return new ApiResponse(0,'success',$return);
    }


    public function actionDistrictList()
    {
        $sql = 'select distinct(district_id) from tuangou_mch where district_id >1 and is_delete=0 and review_status=1';
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $city_list = [];
        if (!empty($data)) {
            foreach ($data as $k=>$v) {
                $city_id[] = $v['district_id'];
            }
            $city_list = District::find()->where(['id' => $city_id])->asArray()->all();
        }
        return new ApiResponse(0,'success',$city_list);
    }




}