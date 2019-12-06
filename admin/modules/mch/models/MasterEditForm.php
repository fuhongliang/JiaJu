<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/27
 * Time: 19:32
 */

namespace app\modules\mch\models;

use app\models\Topic;

/**
 * @property Topic $model
 */
class MasterEditForm extends MchModel
{
    public $model;

    public $store_id;
    public $name;
    public $job;
    public $cover_pic;
    public $info;
    public $advantage;
    public $mobile;
    public $sort;
    public $year;
    public $addtime;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id'], 'required'],
            [['store_id','addtime','sort'], 'integer'],
            [['info'], 'string'],
            [['name', 'cover_pic','job','advantage','mobile','year'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'cover_pic' => '封面图片',
            'name' => '姓名',
            'job' => '职业',
            'advantage' => '特性',
            'info' => '个人简介',
            'mobile' => '手机',
            'sort' => '排序：升序',
            'addtime' => 'Addtime',
            'year' => '工龄',
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->errorResponse;
        $this->model->attributes = $this->attributes;
        $this->model->store_id = $this->store_id;

        if ($this->model->isNewRecord) {
            $this->model->addtime = time();
        }
        if ($this->model->save())
            return [
                'code' => 0,
                'msg' => '保存成功',
            ];
        else
            return $this->getErrorResponse($this->model);
    }
}