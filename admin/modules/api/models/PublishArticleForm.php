<?php
namespace app\modules\api\models;
use app\models\UserArticle;
use app\models\Model;

class PublishArticleForm extends Model
{
    public $store_id;
    public $user_id;

    public $article_content;
    public $article_image;
    public $created_at;
    public $updated_at;
    public $is_delete;


    public function rules()
    {
        return [
            [['store_id','user_id','article_content','article_image',],'required'],
            [['store_id', 'user_id'],'integer'],
            [['created_at','updated_at','is_delete','status'],'safe']
        ];
    }


    public function save()
    {
        if($this->validate()){
            $time = time();
            $userArticle = new UserArticle();

            //判断文字长度
            if (mb_strlen($this->article_content) > 1000) {
                return [
                    'code'=>1,
                    'msg'=>'字数太多了',
                    'data' => $this->article_image,
                ];
            }
            $userArticle->article_content = $this->article_content;
            $article_image = json_decode($this->article_image);

            if (empty($article_image)) {
                return [
                    'code'=>1,
                    'msg'=>'请选择图片',
                    'data' => $this->article_image,
                ];
            }
            if (is_array($article_image)) {
                $userArticle->article_image =json_encode($article_image,JSON_UNESCAPED_UNICODE);
            } else {
                return [
                    'code'=>1,
                    'msg'=>'article_image 需要是数组',
                    'data' => $this->article_image,
                ];
            }
            try {
                $userArticle->user_id = $this->user_id;
                $userArticle->store_id = $this->store_id;
                $userArticle->created_at = $time;
                $userArticle->updated_at = $time;
                $ret = $userArticle->save();
                if (!$ret) {
                    return [
                        'code'=>1,
                        'msg'=>'网络异常'
                    ];
                }
            }catch (\Exception $exception) {
                $msg = $exception->getMessage();
                return [
                    'code'=>1,
                    'msg'=>$msg,
                ];
            }
            return [
                'code'=>0,
                'msg'=>'成功sss',
                'data' => $ret,
            ];
        } else {
            return $this->errorResponse;
        }
    }







}
