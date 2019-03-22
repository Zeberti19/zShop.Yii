<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28.01.2019
 * Time: 20:10
 */

namespace app\models\education;

use yii\base\Model;


class Auth extends Model
{
    public $login;
    public $password;

    public function attributeLabels()
    {
        $attributeLabelMas=parent::attributeLabels();
        $attributeLabelMas["login"]=\yii::t("app","Логин");
        $attributeLabelMas["password"]=\yii::t("app","Пароль");
        return $attributeLabelMas;
    }

    public function rules()
    {
        return [
            [ ["login", "password"], "required"]
               ];
    }
}