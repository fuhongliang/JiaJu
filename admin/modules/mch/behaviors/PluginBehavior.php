<?php


namespace app\modules\mch\behaviors;

use yii\base\Behavior;
use yii\web\Controller;

class PluginBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($e)
    {

    }
}