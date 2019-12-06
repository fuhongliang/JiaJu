<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/14
 * Time: 9:36
 */

namespace app\models;

use Yii;

class Model extends \yii\base\Model
{
    /**
     * 软删除：已删除
     */
    const IS_DELETE_TRUE = 1;

    /**
     * 软删除：未删除
     */
    const IS_DELETE_FALSE = 0;

    /**
     * 手机号正则表达式
     */
    const MOBILE_PATTERN = "/\+?\d[\d -]{8,12}\d/";


    /**
     * Get model error response
     * @param Model $model
     * @return \app\hejiang\ValidationErrorResponse
     */
    public function getErrorResponse($model = null)
    {
        if (!$model) $model = $this;
        return new \app\hejiang\ValidationErrorResponse($model->errors);
    }

    public function getCurrentStoreId()
    {
        return Yii::$app->controller->store->id;
    }

    /**
     * 是否未登录：false否|true是
     * @return int|string
     */
    public function getCurrentUserId()
    {
        if (Yii::$app->mchRoleAdmin->isGuest == false) {
            return Yii::$app->mchRoleAdmin->id;
        }

        if (Yii::$app->user->isGuest == false) {
            return Yii::$app->user->id;
        }

        if (Yii::$app->admin->isGuest == false) {
            return Yii::$app->admin->id;
        }
    }


    public function tranTime($time)
    {
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);

        $time = time() - $time;

        if ($time < 60)
        {
            $str = '刚刚';
        }
        elseif ($time < 60 * 60)
        {
            $min = floor($time/60);
            $str = $min.'分钟前';
        }
        elseif ($time < 60 * 60 * 24)
        {
            $h = floor($time/(60*60));
           // $str = $h.'小时前 '.$htime;
            $str = $h.'小时前 ';
        }
        elseif ($time < 60 * 60 * 24 * 3)
        {
            $d = floor($time/(60*60*24));
            if($d==1)
                $str = '昨天 '.$htime;
            else
                $str = '前天 '.$htime;
        }
        else
        {
            $str = $rtime;
        }
        return $str;
    }

}
