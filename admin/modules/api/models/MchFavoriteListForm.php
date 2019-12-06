<?php
namespace app\modules\api\models;

use app\models\MchFavorite;
use app\models\Mch;
use yii\data\Pagination;
use yii\helpers\VarDumper;

class MchFavoriteListForm extends Model
{
    public $store_id;
    public $user_id;
    public $page;
    public $limit;

    public function rules()
    {
        return [
            [['page', 'limit',], 'integer',],
            [['page'], 'default', 'value' => 1],
            [['limit'], 'default', 'value' => 20],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $query = Mch::find()->from(MchFavorite::tableName())
            ->alias('f')->leftJoin(['m' => Mch::tableName()], 'f.mch_id=m.id')
            ->where(['f.user_id' => $this->user_id, 'f.is_delete' => 0, 'm.is_delete' => 0, 'm.review_status' => 1]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->select('*')->limit($pagination->limit)->offset($pagination->offset)->orderBy('f.created_at DESC')->all();
        $new_list = [];
        foreach ($list as $i => $mch) {
            $new_list[] = (object)[
                'mch_id' => $mch->id,
                'name' => $mch->name,
                'logo' => $mch->logo,
            ];
        }
        return [
            'code' => 0,
            'data' => (object)[
                'row_count' => $count,
                'page_count' => $pagination->pageCount,
                'list' => $new_list,
            ],
        ];
    }
}
