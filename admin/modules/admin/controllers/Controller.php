<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/10/2
 * Time: 13:43
 */

namespace app\modules\admin\controllers;


use app\hejiang\Cloud;
use app\modules\admin\behaviors\AdminBehavior;
use app\modules\admin\behaviors\LoginBehavior;

class Controller extends \app\controllers\Controller
{
    public $layout = 'main';

    public $auth_info;

    public function init()
    {
        parent::init();
        Cloud::checkAuth();
        $this->auth_info = Cloud::getAuthInfo();
    }


    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'permission' => [
                'class' => AdminBehavior::className(),
            ],
            'login' => [
                'class' => LoginBehavior::className(),
            ],
        ]);
    }
}