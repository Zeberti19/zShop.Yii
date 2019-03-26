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
    const SCENARIO_REGISTRATION='registration';
    const SCENARIO_AUTH='auth';
    
    public $login;
    public $password;
    public $email;

    public function scenarios()
    {
        $scenarios=parent::scenarios();
        $scenarios[self::SCENARIO_REGISTRATION]=['login','password','email'];
        $scenarios[self::SCENARIO_AUTH]=['login','password'];
        return $scenarios;
    }

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
            [ ["login", "password", 'email'], "required", "on" => self::SCENARIO_REGISTRATION],
            [ 'email', 'email'],
            [ ["login", "password"], "required", "on" => self::SCENARIO_AUTH]
        ];
    }
}