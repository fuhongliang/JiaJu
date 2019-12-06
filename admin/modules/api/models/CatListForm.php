<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/7/2
 * Time: 0:11
 */

namespace app\modules\api\models;


use app\hejiang\ApiResponse;
use app\models\Cat;

class CatListForm extends Model
{
    public $store_id;
    public $cid;
    public $limit;

    public function rules()
    {
        return [
            [['store_id', 'limit','cid'], 'integer'],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->errorResponse;

        $query = Cat::find()->where([
            'is_delete' => 0,
            'parent_id' => $this->cid,
            'is_show' => 1,
        ]);
        if ($this->store_id)
            $query->andWhere(['store_id' => $this->store_id]);
        if ($this->limit)
            $query->limit($this->limit);
        $query->orderBy('sort ASC');
        $list = $query->select('id,store_id,parent_id,name,pic_url,big_pic_url,advert_pic,advert_url')->asArray()->all();
        foreach ($list as $i => $item) {
            $sub_list = Cat::find()->where([
                'is_delete' => 0,
                'parent_id' => $item['id'],
                'is_show' => 1,
            ])->orderBy('sort ASC')
                ->select('id,store_id,parent_id,name,pic_url,big_pic_url')->asArray()->all();
            $list[$i]['list'] = $sub_list ? $sub_list : [];
        }
        if($this->cid==0){
            $cat = ['name'=>'分类'];
        }else{
            $cat = Cat::find()->where(['is_delete' => 0,'id' => $this->cid,'is_show' => 1])->one();
            $cat = ['name'=>$cat->name];
        }
        $data = [
            'cat'=>$cat,
            'list'=>$list
        ];
        return new ApiResponse(0,'success',$data);
    }
}