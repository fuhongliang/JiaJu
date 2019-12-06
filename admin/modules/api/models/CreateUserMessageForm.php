<?php
namespace app\modules\api\models;
use app\models\Topic;
use app\models\UserMessage;
use app\models\Model;

class CreateUserMessageForm extends Model
{
    public $store_id;
    public $user_id;
    public $contact;
    public $telephone;
    public $message;
    public $created_at;
    public $is_delete=0;
    public $topic_id;



    public function rules()
    {
        return [
            [['store_id', 'topic_id','user_id','contact','telephone','message','created_at'], 'required'],
            [['telephone',], 'string', 'max' => 12],
            [['contact',], 'string', 'max' => 100],
            [['message',], 'string', 'max' => 3000],
            [['is_delete',], 'default', 'value' => 0],
            [['mch_id'],'safe'],
        ];
    }



    public function save()
    {
        if($this->validate()){
            $topicInfo = Topic::find()->where(['id'=>$this->topic_id])->asArray()->one();
            if (!empty($topicInfo)) {
                $userMessage = new UserMessage();
                try {
                    $userMessage->topic_id = $topicInfo['id'];
                    $userMessage->user_id = $this->user_id;
                    $userMessage->store_id = $this->store_id;
                    $userMessage->created_at = $this->created_at;
                    $userMessage->mch_id = $topicInfo['mch_id'];
                    $userMessage->contact = $this->contact;
                    $userMessage->telephone = $this->telephone;
                    $userMessage->message = $this->message;
                    $userMessage->is_delete = $this->is_delete;
                    $ret = $userMessage->save();
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
                    'msg'=>'成功',
                    'data' => $ret,
                ];
            } else {
                return [
                    'code'=>1,
                    'msg'=>'文章不存在',
                    'data' => [],
                ];
            }
        } else {
            return $this->errorResponse;
        }
    }







}
