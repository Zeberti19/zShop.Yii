<?php

namespace app\models;

use yii\db\ActiveRecord;

class CategoryGoods extends ActiveRecord
{
    public function getGoods()
    {
        return $this->hasMany( Goods::class, [ 'id' => 'goods_id' ] )->viaTable('category_goods_goods_ref',['category_id'=>'id']);
    }

    static function tableName()
    {
        return "category_goods";
    }

    public function rules()
    {
        return [
            [['id', 'name'], 'required']
            ];
    }
}