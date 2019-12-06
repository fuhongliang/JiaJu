<?php
namespace app\modules\api\models;


use app\models\MchFavorite;

class MchFavoriteAddForm extends Model
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
        $existFavorite = MchFavorite::find()->where([
            'store_id' => $this->store_id,
            'user_id' => $this->user_id,
            'mch_id' => $this->mch_id,
            'is_delete' => 0,
        ])->one();
        if ($existFavorite) {
            return [
                'code' => 0,
                'msg' => 'success',
            ];
        }
        $favorite = new MchFavorite();
        $favorite->store_id = $this->store_id;
        $favorite->user_id = $this->user_id;
        $favorite->mch_id = $this->mch_id;
        $favorite->created_at = time();
        if ($favorite->save()) {
            return [
                'code' => 0,
                'msg' => 'success',
                'data' => [
                    $this->store_id,$this->user_id,$this->mch_id
                ]
            ];
        } else {
            return [
                'code' => 1,
                'msg' => 'fail',
            ];
        }
    }
}
