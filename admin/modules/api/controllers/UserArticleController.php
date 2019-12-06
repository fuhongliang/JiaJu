<?php
namespace app\modules\api\controllers;
use app\models\UserArticle;
use app\modules\api\behaviors\LoginBehavior;
use app\modules\api\models\PublishArticleForm;
use app\hejiang\ApiResponse;
use app\hejiang\BaseApiResponse;
use app\modules\api\models\UserArticleForm;
use app\modules\api\models\UserArticleListForm;

class UserArticleController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'login' => [
                'class' => LoginBehavior::className(),
            ],
        ]);
    }

    /**
     * @desc 发布图文
     * @return BaseApiResponse
     */
    public function actionPublish()
    {
        $form = new PublishArticleForm();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $form->attributes = \Yii::$app->request->post();
        return new BaseApiResponse($form->save());
    }

    public function actionUserArticle()
    {
        $userArticle = new UserArticleListForm();
        $getData =\Yii::$app->request->get();
        $userArticle->attributes = $getData;
        $userArticle->store_id = $this->store->id;
        return new BaseApiResponse($userArticle->articleList());
    }

    public function actionMyArticle()
    {
        $userArticle = new UserArticleListForm();
        $getData =\Yii::$app->request->get();
        $userArticle->attributes = $getData;
        $userArticle->store_id = $this->store->id;
        return new BaseApiResponse($userArticle->myArticleList());
    }

    public function actionArticleDetail()
    {
        $userArticle = new UserArticleForm();
        $getData =\Yii::$app->request->get();
        $userArticle->attributes = $getData;
        $userArticle->store_id = $this->store->id;
        return new BaseApiResponse($userArticle->search());
    }


    /**
     * @desc 删除图文
     * @return BaseApiResponse
     */
    public function actionDelete()
    {
        $user_id = \Yii::$app->user->id;
        $id = \Yii::$app->request->post('id');
        $model = UserArticle::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
            'user_id' => $user_id
        ]);
        if ($model) {
            $model->is_delete = 1;
            try{
                $model->save();
            }catch (\Exception $exception) {
                $msg = $exception->getMessage();
                $ret =[
                    'code' => 1,
                    'msg' => $msg,
                    'data' => [],
                ];
                return new BaseApiResponse($ret);
            }
        }
        $ret =[
            'code' => 0,
            'msg' => '删除成功',
            'data' => [],
        ];
        return new BaseApiResponse($ret);
    }






}
