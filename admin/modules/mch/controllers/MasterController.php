<?php

/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/27
 * Time: 9:50
 */

namespace app\modules\mch\controllers;

use app\models\Master;
use app\modules\mch\models\MasterEditForm;
use yii\data\Pagination;

class MasterController extends Controller
{
    public function actionIndex()
    {
        $query = (new \yii\db\Query())->select([])->from(['master' => Master::tableName()])->where(['store_id' => $this->store->id]);

        $count = $query->count();
        $pagination = new Pagination([
            'totalCount' => $count,
        ]);
        $list = $query->orderBy('sort ASC,addtime DESC')->limit($pagination->limit)->offset($pagination->offset)->all();

        return $this->render('index', [
            'list' => $list,
            'pagination' => $pagination
        ]);
    }

    public function actionEdit($id = null)
    {
        $model = Master::findOne([
            'id' => $id,
            'store_id' => $this->store->id
        ]);

        if (!$model) {
            $model = new Master();
        }
        if (\Yii::$app->request->isPost) {
            $form = new MasterEditForm();
            $form->store_id = $this->store->id;
            $form->attributes = \Yii::$app->request->post();

            $form->model = $model;
            return $form->save();
        } else {
            $model->sort = 1000;
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = Master::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
        ]);
        if ($model) {
            $model->delete();
        }
        return [
            'code' => 0,
            'msg' => '操作成功！',
        ];
    }
}
