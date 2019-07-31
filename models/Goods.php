<?php

namespace app\models;

use yii\db\ActiveRecord;

class Goods extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id', 'name'], 'required']
        ];
    }
}