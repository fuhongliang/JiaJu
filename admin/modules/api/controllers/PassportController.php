<?php
namespace app\modules\api\controllers;

use app\models\Share;
use app\models\User;
use app\modules\api\models\LoginForm;
use app\hejiang\ApiResponse;
use Curl\Curl;

class PassportController extends Controller
{
    public function actionLogin()
    {
        $form = new LoginForm();
        $form->attributes = \Yii::$app->request->post();
        $form->wechat_app = $this->wechat_app;
        $form->store_id = $this->store->id;
        return $form->login();
    }

    public function actionAppLogin()
    {
        $post_data = \Yii::$app->request->post();
        if (empty($post_data['code'])) {
            return new ApiResponse(1,'缺少code参数',$post_data);
        }
        $res = $this->getUnionid($post_data['code']);
        if (!$res || empty($res['unionid'])) {
            return new ApiResponse(1,'获取用户unionid失败',$res);
        }
        $unionid = $res['unionid'];
        $user = User::findOne(['wechat_union_id' => $unionid, 'store_id' => $this->store->id]);
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        $user_info = $this->getUserInfo($access_token,$openid);
        $nickname = !empty($user_info['nickname']) ? $user_info['nickname'] : '';
        $avatar_url = !empty($user_info['headimgurl']) ? $user_info['headimgurl'] : '';
        if (empty($user)) {
            $user = new User();
            $user->type = 1;
            $user->username = $res['openid'];
            $user->password = \Yii::$app->security->generatePasswordHash(\Yii::$app->security->generateRandomString(), 5);
            $user->auth_key = \Yii::$app->security->generateRandomString();
            $user->access_token = \Yii::$app->security->generateRandomString();
            $user->addtime = time();
            $user->is_delete = 0;
            $user->wechat_open_id = $res['openid'];
            $user->wechat_union_id = $res['unionid'];
            $user->nickname = preg_replace('/[\xf0-\xf7].{3}/', '', $nickname);
            $user->avatar_url = $avatar_url ? $avatar_url : \Yii::$app->request->hostInfo . \Yii::$app->request->baseUrl . '/statics/images/avatar.png';
            $user->store_id = $this->store->id;
            $user->save();
        } else {
            if (!empty($nickname) || !empty($avatar_url)) {
                if (!empty($nickname)) {
                    $user->nickname = preg_replace('/[\xf0-\xf7].{3}/', '', $nickname);
                }
                if (!empty($avatar_url)) {
                    $user->avatar_url = $avatar_url;
                }
                $user->save();
            }
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
    }

    /**
     * http请求方式: GET
    https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID
     */
    private function getUserInfo($token,$openid)
    {
        $api = "https://api.weixin.qq.com/sns/userinfo?access_token={$token}&openid={$openid}";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($api);
        $res = $curl->response;
        $res = json_decode($res, true);
        return $res;
    }


    /**
     * @desc app登录获取union id
     * @param $code
     * @return mixed|string
     * @throws \ErrorException
     */
    private function getUnionid($code)
    {
        $appid = 'wx4cb54f0fb9038e2e';
        $appsecret = 'e8fee5b098bdc8eda57d1b508a594ae2';
        $api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($api);
        $res = $curl->response;
        $res = json_decode($res, true);
        return $res;
    }




}
