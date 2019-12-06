<?php

namespace app\services;

use Curl\Curl;
use luweiss\wechat\DataTransform;

class AppWxPayService
{
    public $appid = 'wx4cb54f0fb9038e2e';
    public $appsecret = 'e8fee5b098bdc8eda57d1b508a594ae2';
    public $mch_id = '1552335701';
    public $apiKey = '1610IFHUCOM1610XFIGOCOM1610100GO';


    public function unifiedOrder($args)
    {
        //body
        //商户订单号	out_trade_no
        //总金额	total_fee
        //通知地址	notify_url
        //交易类型	trade_type
        unset($args['openid']);

        $args['trade_type'] = 'APP';
        $args['appid'] = $this->appid;
        $args['mch_id'] = $this->mch_id;
        $args['nonce_str'] = md5(uniqid());
        //$args['sign_type'] = 'MD5';
        $args['spbill_create_ip'] = '127.0.0.1';
        $args['sign'] = $this->makeSign($args);
        $xml = DataTransform::arrayToXml($args);
        $api = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $curl = new Curl();
        $curl->post($api, $xml);
        if (!$curl->response)
            return false;
        return DataTransform::xmlToArray($curl->response);

    }




    public function makeSign($args)
    {
        if (isset($args['sign']))
            unset($args['sign']);
        ksort($args);
        foreach ($args as $i => $arg) {
            if ($args === null || $arg === '')
                unset($args[$i]);
        }
        $string = DataTransform::arrayToUrlParam($args, false);
        $string = $string . "&key={$this->apiKey}";
        $string = md5($string);
        $result = strtoupper($string);
        return $result;
    }







}