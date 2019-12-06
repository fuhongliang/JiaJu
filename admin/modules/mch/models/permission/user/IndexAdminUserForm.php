<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 
 * author: wxf
 */

namespace app\modules\mch\models\permission\user;


use app\models\User;
use app\modules\mch\models\MchModel;
use yii\data\Pagination;

class IndexAdminUserForm extends MchModel
{
    public $limit;
    public $page;


    public function rules()
    {
        return [
            [['limit', 'page'], 'integer'],
            [['page'], 'default', 'value' => 1],
            [['limit'], 'default', 'value' => 20],
        ];
    }

    public function pagination()
    {
        if (!$this->validate()) {
            return $this->getErrorResponse();
        }

        $model = User::find()->andWhere(['type' => User::USER_TYPE, 'store_id' => $this->getCurrentStoreId(), 'is_delete' => \app\models\Model::IS_DELETE_FALSE]);
        $pagination = new Pagination(['totalCount' => $model->count(), 'pageSize' => $this->limit]);

        $list = $model->limit($this->limit)->offset($pagination->offset)->all();

        return [
            'list' => $list,
            'pagination' => $pagination
        ];
    }
}