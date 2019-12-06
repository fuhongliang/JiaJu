<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/28
 * Time: 14:11
 */

namespace app\modules\api\models;


use app\hejiang\ApiResponse;
use app\models\Topic;
use app\models\Mch;
use yii\data\Pagination;
use app\models\TopicType;

class TopicListForm extends Model
{
    public $store_id;

    public $page;
    public $limit = 20;
    public $type;
    public $is_chosen;
    public $mch_id = 0;

    public function rules()
    {
        return [
            [['page','mch_id',], 'integer'],
            [['page'], 'default', 'value' => 1],
            ['type', 'integer'],
            ['is_chosen','integer'],
        ];
    }

    public function search()
    {

        if($this->type==='-1'){
            $query = Topic::find()->where(['store_id' => $this->store_id, 'is_delete' => 0,'is_chosen' =>1]);
        }elseif($this->type){
            $query = Topic::find()->where(['store_id' => $this->store_id, 'is_delete' => 0])->andWhere('type=:type',[':type' => $this->type]);
        }else{
             $query = Topic::find()->where(['store_id' => $this->store_id, 'is_delete' => 0]);
        }
        if (!empty($this->mch_id)) {
            $query->andWhere(['mch_id' => $this->mch_id]);
        }

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->orderBy('sort ASC,addtime DESC')->limit($pagination->limit)->offset($pagination->offset)
            ->select('*')->asArray()->all();

        foreach ($list as $i => $item) {
            if (!empty($item['mch_id'])) {
                $mch_info = Mch::find()->where(['id' => $item['mch_id']])->one();
                $list[$i]['author'] = $mch_info['name'];
                $list[$i]['author_logo'] = $mch_info['logo'];
            } else {
                $list[$i]['author'] = '官方平台';
                $list[$i]['author_logo'] = 'http://yiwuyimei.oss-cn-beijing.aliyuncs.com/web/uploads/image/c6/c6cca29ee69a352a677ae520545a16a368de1472.png';
            }

            $list[$i]['addtime'] = $this->tranTime($item['addtime']);

            $read_count = intval($item['read_count'] + $item['virtual_read_count']);
            unset($list[$i]['read_count']);
            unset($list[$i]['virtual_read_count']);
            if ($read_count < 10000) {
                $read_count = $read_count . '人浏览';
            }
            if ($read_count >= 10000) {
                $read_count = intval($read_count / 10000) . '万+人浏览';
            }
            $goods_class = 'class="goods-link"';
            $goods_count = mb_substr_count($item['content'], $goods_class);
            unset($list[$i]['content']);
            $list[$i]['read_count'] = $read_count;
            if ($goods_count)
                $list[$i]['goods_count'] = $goods_count . '件宝贝';
        }
        return new ApiResponse(0,'success',['list'=>$list]);

    }




}
