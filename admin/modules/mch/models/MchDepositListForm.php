<?php
namespace app\modules\mch\models;

use app\models\AgentDistrict;
use app\models\Mch;
use app\models\MchCash;
use app\models\User;
use app\models\MchDeposit;
use Yii;
use yii\data\Pagination;

class MchDepositListForm extends MchModel
{
    public $store_id;
    public $status;
    public $page;

    public function rules()
    {
        return [
            [['status', 'page'], 'integer'],
            [['page'], 'default', 'value' => 1],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $query = MchDeposit::find()->alias('md')
            ->leftJoin(['m' => Mch::tableName()], 'md.mch_id=m.id')
            ->where([
                'm.store_id' => $this->store_id,
                'md.is_delete' => 0,
            ]);

        // 是否是代理登录
        if (Yii::$app->mchRoleAdmin->identity->is_agent) {
            $query->innerJoin(['d' => AgentDistrict::tableName()], 'd.district_id=m.district_id')
                ->andWhere(['d.user_id'=>Yii::$app->mchRoleAdmin->identity->id]);
        }

        if ($this->status != -1) {
            $query->andWhere(['md.status' => $this->status]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1,]);
        $list = $query->select('m.name,md.*')
            ->limit($pagination->limit)->offset($pagination->offset)
            ->orderBy('md.created_at DESC')
            ->asArray()->all();
        return [
            'code' => 0,
            'data' => [
                'pagination' => $pagination,
                'list' => $list,
            ],
        ];
    }
}
