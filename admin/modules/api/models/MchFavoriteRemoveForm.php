<?php
namespace app\modules\api\models;


use app\models\MchFavorite;

class MchFavoriteRemoveForm extends Model
{
    public $store_id;
    public $user_id;
    public $mch_id;

    public function rules()
    {
        return [
            [['mch_id'], 'required',],
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $res = MchFavorite::updateAll(['is_delete' => 1], [
            'store_id' => $this->store_id,
            'user_id' => $this->user_id,
            'mch_id' => $this->mch_id,
        ]);
        if ($res)
            return [
                'code' => 0,
                'msg' => 'success',
            ];
        else
            return [
                'code' => 1,
                'msg' => 'fail',
            ];
    }
}
