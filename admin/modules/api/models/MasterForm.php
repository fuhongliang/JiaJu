<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/28
 * Time: 14:11
 */

namespace app\modules\api\models;


use app\extensions\GetInfo;
use app\hejiang\ApiResponse;
use app\models\Master;
use yii\helpers\VarDumper;

class MasterForm extends Model
{
    public $store_id;
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
        $model = Master::find()->where(['store_id' => $this->store_id, 'id' => $this->id])
            ->asArray()->one();

        if (empty($model))
            return new ApiResponse(1,'内容不存在');

        $model['addtime'] = date('Y-m-d', $model['addtime']);
        $model['info'] = $this->transTxvideo($model['info']);
        return new ApiResponse(0,'success',$model);
    }

    private function transTxvideo($content)
    {
        preg_match_all("/https\:\/\/v\.qq\.com[^ '\"]+\.html/i", $content, $match_list);
        if (!is_array($match_list) || count($match_list) == 0)
            return $content;
        $url_list = $match_list[0];
        foreach ($url_list as $url) {
            $res = GetInfo::getVideoInfo($url);
            if ($res['code'] == 0) {
                $new_url = $res['url'];
                $content = str_replace('src="' . $url . '"', 'src="' . $new_url . '"', $content);
            }
        }
        return $content;
    }
}