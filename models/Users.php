<?php

namespace app\models;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    public function rules()
    {
        return [
            //TODO добавить разные правила для разных сценариев (создание, редактирование, удаление и т.п.)
            [ 'id', 'safe' ],
            [ ['surname', 'patronymic', 'first_name'], 'required' ]
        ];
    }
}