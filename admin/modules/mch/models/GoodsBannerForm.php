<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 16:27
 */

namespace app\modules\mch\models;

use app\models\GoodsBanner;
use yii\data\Pagination;

class GoodsBannerForm extends MchModel
{
    public $model;

    public $store_id;
    public $pic_url;
    public $title;
    public $page_url;
    public $sort;
    public $open_type;
    public $type;

    /**
     * @return array
     * 验证
     */
    public function rules()
    {
        return [
            [['store_id', 'pic_url',], 'required'],
            [['store_id','type'], 'integer'],
            [['pic_url', 'page_url','open_type'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['title'],'default','value'=>'暂无标题'],
            [['sort'],'default','value'=>0],
            [['sort'],'integer','min'=>0,'max'=>999999]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'store_id' => '商城id',
            'pic_url' => '图片',
            'title' => '标题',
            'page_url' => '页面路径',
            'sort' => '排序',
            'is_delete' => '是否删除：0=未删除，1=已删除',
        ];
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList($store_id)
    {
        $query = GoodsBanner::find()->andWhere(['is_delete' => 0, 'store_id' => $store_id, 'type' => 1]);
        $count = $query->count();
        $p = new Pagination(['totalCount' => $count, 'pageSize' => 20]);
        $list = $query
            ->orderBy('sort ASC')
            ->offset($p->offset)
            ->limit($p->limit)
            ->asArray()
            ->all();

        return [$list, $p];
    }

    public function save()
    {
        if ($this->validate()) {
            $model = $this->model;
            if ($model->isNewRecord) {
                $model->is_delete = 0;
                $model->addtime = time();
            }
            if($this->type == 3){
                $model->type = 3;
            }else{
                $model->type = 1;
            }

            $model->attributes = $this->attributes;
            return $model->saveBanner();
        } else {
            return $this->errorResponse;
        }
    }
}