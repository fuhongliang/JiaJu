<?php
namespace app\models;

use Yii;
use yii\helpers\VarDumper;


/**
 * @property string $user_id
 * @property string $article_image
 * @property string $article_content
 * @property string $store_id
 */


class UserArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_article}}';
    }


    public function rules()
    {
        return [
            [['store_id','user_id','article_content','article_image',],'required'],
            [['store_id', 'user_id'],'integer'],
            [['created_at','updated_at','is_delete','status'],'safe']
        ];
    }







}