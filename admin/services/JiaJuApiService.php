<?php
namespace app\services;
use Yii;

class JiaJuApiService
{

    /**
     * @param $data
     * @param $url
     * @return array
     */
    public function AccessJiaJuApi($url,$data)
    {
        $jiaJuApi = Yii::$app->params['jiaJuApi'];
        $app_key = $jiaJuApi['key'];
        $app_secret = $jiaJuApi['secret'];
        $host = $jiaJuApi['host'];
        $nonce_str = md5(uniqid());
        $access_time = time();
        $access_sign = md5(md5($nonce_str.$app_secret).$access_time);
        $data['app_key'] = $app_key;
        $data['access_sign'] = $access_sign;
        $data['nonce_str'] = $nonce_str;
        $data['access_time'] = $access_time;
        return $this->http_post_json($host.$url,json_encode($data));
    }


    public function http_post_json($url, $jsonStr)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonStr)
            )
        );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array($httpCode, $response);
    }


}