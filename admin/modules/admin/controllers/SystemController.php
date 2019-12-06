<?php

/**
 * @link http://www.zjhejiang.com/
 * @copyright Copyright (c) 2018 
 * @author Lu Wei
 *
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/5/22
 * Time: 16:08
 */

namespace app\modules\admin\controllers;

use app\models\common\admin\db\CommonDbOptimize;
use Yii;

class SystemController extends Controller
{
    /**
     * 数据库优化
     */
    public function actionDbOptimize()
    {
        if (Yii::$app->request->isPost) {
            $form = new CommonDbOptimize();
            $form->attributes = Yii::$app->request->post();
            return $form->run();
        } else {
            return $this->render('db-optimize');
        }
    }
}
