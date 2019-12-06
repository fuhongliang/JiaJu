<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/2/28
 * Time: 16:26
 */

namespace app\modules\mch\models\mch;


use app\models\AgentDistrict;
use app\models\Mch;
use app\models\User;
use app\modules\mch\models\MchModel;
use yii\data\Pagination;
use Yii;

class MchListForm extends MchModel
{
    public $store_id;
    public $review_status;
    public $page;
    public $limit;
    public $keyword;

    public function rules()
    {
        return [
            [['review_status', 'page', 'limit'], 'integer'],
            [['keyword',], 'trim'],
            [['page',], 'default', 'value' => 1,],
            [['limit',], 'default', 'value' => 20,],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $query = Mch::find()->alias('m')->leftJoin(['u' => User::tableName()], 'm.user_id=u.id')
            ->where([
                'm.is_delete' => 0,
                'm.store_id' => $this->store_id,
            ]);

        // 是否是代理登录
        if (Yii::$app->mchRoleAdmin->identity->is_agent) {
            $query->innerJoin(['d' => AgentDistrict::tableName()], 'd.district_id=m.district_id')
                ->andWhere(['d.user_id'=>Yii::$app->mchRoleAdmin->identity->id]);
        }
        if ($this->keyword) {
            $query->andWhere([
                'OR',
                ['LIKE', 'm.realname', $this->keyword],
                ['LIKE', 'm.tel', $this->keyword],
                ['LIKE', 'm.name', $this->keyword],
                ['LIKE', 'u.nickname', $this->keyword],
            ]);
        }
        if ($this->review_status !== null) {
            $query->andWhere([
                'm.review_status' => $this->review_status,
            ]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1, 'pageSize' => $this->limit]);
        $list = $query->orderBy('m.sort,m.addtime DESC')->limit($pagination->limit)->offset($pagination->offset)
            ->select('m.*,u.nickname,u.avatar_url')->asArray()->all();
        return [
            'code' => 0,
            'data' => [
                'list' => $list,
                'pagination' => $pagination,
            ],
        ];
    }
}