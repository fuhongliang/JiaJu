<?php
namespace app\modules\mch\models\mch;

use app\models\Mch;
use app\models\MchDeposit;
use app\modules\mch\models\MchModel;

class MchDepositConfirmForm extends MchModel
{
    public $id;
    public $store_id;
    public $status;

    public function rules()
    {
        return [
            [['id', 'status'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $cash = MchDeposit::findOne([
            'id' => $this->id,
            'store_id' => $this->store_id,
        ]);
        if (!$cash)
            return [
                'code' => 1,
                'msg' => '申请记录不存在。',
            ];
        $mch = Mch::findOne($cash->mch_id);
        if ($this->status == 2) {//拒绝
            $cash->status = 2;
            $cash->save(false);
            return [
                'code' => 0,
                'msg' => '操作成功。',
            ];
        }
        if ($this->status == 1) {//审核通过
            $cash->status = 1;
            $cash->save(false);
            return [
                'code' => 0,
                'msg' => '操作成功。',
            ];
        }
    }
}
