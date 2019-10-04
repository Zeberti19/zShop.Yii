<?php

namespace app\models;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    //TODO придумать какую-нить модель, где имя таблицы действительно не совпадает с именем класса
    static public function tableName()
    {
        return "users";
    }

    public function rules()
    {
        return [
            //TODO добавить разные правила для разных сценариев (создание, редактирование, удаление и т.п.)
            [ 'id', 'safe' ],
            [ ['surname', 'patronymic', 'first_name'], 'required' ]
        ];
    }
}