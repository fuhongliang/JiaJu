<?php
namespace app\modules\api\models;
use app\models\User;
use app\models\UserArticle;
use app\models\Model;
use yii\data\Pagination;
use app\models\Topic;
use app\hejiang\ApiResponse;

class UserArticleForm extends Model
{

    public $store_id;
    public $user_id;
    public $id;

    public function rules()
    {
        return [
            ['id', 'required'],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $model = UserArticle::find()->where(['store_id' => $this->store_id, 'id' => $this->id, 'is_delete' => 0])
            ->select('*')->asArray()->one();
        if (empty($model)) {
            return [
                'code' => 1,
                'msg' => '内容不存在',
                'data' => [],
            ];
        }
        //获取用户信息
        $user_info = User::find()->where(['id'=>$model['user_id']])->select('id,nickname,avatar_url')->asArray()->one();
        $model['nickname'] = $user_info['nickname'];
        $model['avatar_url'] = $user_info['avatar_url'];
        $model['created_date'] = date('Y-m-d H:i', $model['created_at']);
        $model['created_at'] = $this->tranTime($model['created_at']);
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'detail' => $model,
            ],
        ];
    }



}
