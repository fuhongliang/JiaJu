<?php
namespace app\modules\api\models;
use app\models\User;
use app\models\UserArticle;
use app\models\Model;
use yii\data\Pagination;
use app\models\Topic;

class UserArticleListForm extends Model
{
    public $store_id;
    public $page;
    public $limit;

    public function rules()
    {
        return [
            [['page', 'limit',], 'integer'],
            [['page',], 'default', 'value' => 1],
            [['limit',], 'default', 'value' => 5],
        ];
    }


    public function articleList()
    {
        $query = UserArticle::find()->where([
            'status' => 1,
            'is_delete' => 0,
            'store_id' => $this->store_id,
        ]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->limit($pagination->limit)->offset($pagination->offset)->orderBy('created_at DESC')->asArray()->all();

        if (!empty($list)) {
            //获取user_id
            foreach ($list as $key=>$value) {
                $user_id[] = $value['user_id'];
            }
            //获取用户信息
            $user_list = User::find()->where([
                'in','id',$user_id
            ])->select('id,nickname,avatar_url')->asArray()->all();
        }
        foreach($list as $k=>$v) {
            foreach ($user_list as $uk=>$uv) {
                if ($v['user_id'] == $uv['id']) {
                    $list[$k]['nickname'] = $uv['nickname'];
                    $list[$k]['avatar_url'] = $uv['avatar_url'];
                }
            }
            $list[$k]['article_image'] = json_decode($v['article_image'],true);
            $list[$k]['created_at'] = $this->tranTime($v['created_at']);
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'row_count' => $count,
                'page_count' => $pagination->pageCount,
                'list' => $list,
            ],
        ];
    }

    public function myArticleList()
    {
        $query = UserArticle::find()->where([
            'is_delete' => 0,
            'store_id' => $this->store_id,
            'user_id' => \Yii::$app->user->id,
        ]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->limit($pagination->limit)->offset($pagination->offset)->orderBy('created_at DESC')->asArray()->all();

        if (!empty($list)) {
            //获取user_id
            foreach ($list as $key=>$value) {
                $user_id[] = $value['user_id'];
            }
            //获取用户信息
            $user_list = User::find()->where([
                'in','id',$user_id
            ])->select('id,nickname,avatar_url')->asArray()->all();
        }

        foreach($list as $k=>$v) {
            foreach ($user_list as $uk=>$uv) {
                if ($v['user_id'] == $uv['id']) {
                    $list[$k]['nickname'] = $uv['nickname'];
                    $list[$k]['avatar_url'] = $uv['avatar_url'];
                }
            }
            $list[$k]['article_image'] = json_decode($v['article_image'],true);
            $list[$k]['created_at'] = $this->tranTime($v['created_at']);
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'row_count' => $count,
                'page_count' => $pagination->pageCount,
                'list' => $list,
            ],
        ];
    }

}
