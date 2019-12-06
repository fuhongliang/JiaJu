<?php
namespace app\modules\api\controllers;

use app\modules\api\models\MchTopicListForm;

class TopicController extends Controller
{
    public function actionIndex()
    {
        $form = new MchTopicListForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store_id;
        return $form->search();
    }








}
