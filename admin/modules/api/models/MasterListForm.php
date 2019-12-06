<?php
/**
 * Created by wufeng
 * User: wufeng
 * Date: 2018/11/01
 * Time: 14:11
 */

namespace app\modules\api\models;


use app\hejiang\ApiResponse;
use app\models\Master;
use yii\data\Pagination;

class MasterListForm extends Model
{
    public $store_id;

    public $page;
    public $limit = 20;

    public function rules()
    {
        return [
            [['page'], 'integer'],
            [['page'], 'default', 'value' => 1],
        ];
    }

    public function search()
    {
        $query = Master::find()->where(['store_id' => $this->store_id]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->orderBy('sort ASC,addtime DESC')->limit($pagination->limit)->offset($pagination->offset)
            ->select('id,name,job,cover_pic,advantage,mobile,info,addtime,year,sort')->asArray()->all();

        foreach ($list as $i => $item) {
            $list[$i]['addtime'] = date('Y-m-d',$item['addtime']);
        }
        return new ApiResponse(0,'success',['list'=>$list]);
    }
}