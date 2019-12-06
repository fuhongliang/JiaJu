<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/7/1
 * Time: 16:52
 */

namespace app\modules\api\models;


use app\hejiang\ApiResponse;
use app\models\Setting;
use app\models\Share;
use app\models\User;
use Curl\Curl;

class LoginForm extends Model
{
    public $wechat_app;

    public $code;
    public $user_info;
    public $encrypted_data;
    public $iv;
    public $signature;

    public $store_id;

    public function rules()
    {
        return [
            [['wechat_app', 'code', 'user_info', 'encrypted_data', 'iv', 'signature',], 'required'],
        ];
    }

    public function login()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $res = $this->getOpenid($this->code);
        if (!$res || empty($res['openid'])) {
            return new ApiResponse(1,'获取用户OpenId失败',$res);
        }
        $session_key = $res['session_key'];
        require __DIR__ . '/wxbdc/WXBizDataCrypt.php';
        $pc = new \WXBizDataCrypt($this->wechat_app->app_id, $session_key);
        $errCode = $pc->decryptData($this->encrypted_data, $this->iv, $data);
        if ($errCode == 0) {
            $data = json_decode($data, true);
            if (!empty($data['unionId'])) {
                $user = User::findOne(['wechat_union_id' => $data['unionId'], 'store_id' => $this->store_id]);
            }
            if (empty($user)) {
                $user = User::findOne(['wechat_open_id' => $data['openId'], 'store_id' => $this->store_id]);
            }
            if (!$user) {
                $user = new User();
                $user->type = 1;
                $user->username = $data['openId'];
                $user->password = \Yii::$app->security->generatePasswordHash(\Yii::$app->security->generateRandomString(), 5);
                $user->auth_key = \Yii::$app->security->generateRandomString();
                $user->access_token = \Yii::$app->security->generateRandomString();
                $user->addtime = time();
                $user->is_delete = 0;
                $user->wechat_open_id = $data['openId'];
                $user->wechat_union_id = isset($data['unionId']) ? $data['unionId'] : '';
                $user->nickname = preg_replace('/[\xf0-\xf7].{3}/', '', $data['nickName']);
                $user->avatar_url = $data['avatarUrl'] ? $data['avatarUrl'] : \Yii::$app->request->hostInfo . \Yii::$app->request->baseUrl . '/statics/images/avatar.png';
                $user->store_id = $this->store_id;
                $user->save();
                //注释掉
//                $same_user = User::find()->select('id')->where([
//                    'AND',
//                    [
//                        'store_id' => $this->store_id,
//                        'wechat_open_id' => $data['openId'],
//                        'is_delete' => 0,
//                    ],
//                    ['<', 'id', $user->id],
//                ])->one();
//                if ($same_user) {
//                    $user->delete();
//                    $user = null;
//                    $user = $same_user;
//                }
            } else {
                if (!empty($data['unionId'])) {
                    $user->wechat_union_id = $data['unionId'];
                }
                $user->nickname = preg_replace('/[\xf0-\xf7].{3}/', '', $data['nickName']);
                $user->avatar_url = $data['avatarUrl'];
                $user->save();
            }
            $share = Share::findOne(['user_id' => $user->parent_id]);
            $share_user = User::findOne(['id' => $share->user_id]);
            $data = [
                'access_token' => $user->access_token,
                'nickname' => $user->nickname,
                'avatar_url' => $user->avatar_url,
                'is_distributor' => $user->is_distributor ? $user->is_distributor : 0,
                'parent' => $share->id ? ($share->name ? $share->name : $share_user->nickname) : '总店',
                'id' => $user->id,
                'is_clerk' => $user->is_clerk,
                'integral' => $user->integral,
                'money' => $user->money,
                'res' => $res,
            ];
            return new ApiResponse(0,'success',$data);
        } else {
            return new ApiResponse(1,'登录失败',$errCode);
        }


    }


    private function getOpenid($code)
    {
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->wechat_app->app_id}&secret={$this->wechat_app->app_secret}&js_code={$code}&grant_type=authorization_code";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($api);
        $res = $curl->response;
        $res = json_decode($res, true);
        return $res;
    }
}