<?php
namespace app\services;
use app\services\JiaJuApiService;

class PushService
{

    public function newOrder($registration_id)
    {
        $jiaJuService =  new JiaJuApiService();
        return $jiaJuService->AccessJiaJuApi('/push/neworder',['registration_id'=>$registration_id]);
    }




}