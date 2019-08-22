<?php

namespace app\models;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    public function rules()
    {
        return [
            [['surname', 'patronymic', 'first_name'], 'required']
        ];
    }
}