<?php

namespace app\models;

use app\components\helpers\Cookie;
use app\components\helpers\Encode;
use Exception;
use Yii;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    const SCENARIO_CRUD='CRUD';
    const SCENARIO_SHOW='show';

    protected $privsMas=null;

    public function attributeLabels()
    {
        //TODO добавить метки всем аттрибутам
        return [ 'id' =>  Yii::t('app','id'),
                 'login' =>  Yii::t('app','login'),
                 'password' =>  Yii::t('app','password'),
        ];
    }

    /**
     * Авторизует пользователя. Данные для авторизации из параметров функции. Если параметры не указаны, то
     * данные возьмет из кук. В случаи ошибок или неуспешной авторизации выбрасывате исключения
     * @param null|string $login
     * @param null|string $password
     * @param bool $passwordIsHash
     * @throws \Exception
     */
    static public function auth($login=null,$password=null,$passwordIsHash=true)
    {
        $errMesPref='Авторизация. ';
        $login=(!$login and isset($_COOKIE['user_login']))? $_COOKIE['user_login'] : $login;
        if(!$password and $passwordIsHash) $password=isset($_COOKIE['user_login'])?$_COOKIE['user_password']:$password;
        //TODO проверить, что будет если передать логин или пароль в виде строки "0"
        if ((!$login and 0 !==$login )
            or !$password)
            throw new Exception($errMesPref.'Логин или пароль не указаны ни в параметрах функции "auth", ни в куках',0);
        $User=static::findOne(['login'=>$login]);
        if (!$User) throw new Exception($errMesPref.'Указанный логин не существует',1);
        $passHash=$passwordIsHash? $password : Encode::passwordEncode($password,$User->salt);
        $User=static::findOne(['login'=>$login,'password'=>$passHash]);
        if (!$User) throw new Exception($errMesPref.'Неверный пароль',2);
        //
        if (session_status() != PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id']=$User->id;
        $_SESSION['user_login']=$User->login;
        $rolesId=[];
        $privsId=[];
        foreach($User->roles as $Role) $rolesId[]=$Role->id;
        foreach($User->privs as $Priv) $privsId[]=$Priv->id;
        $_SESSION['user_roles']=$rolesId;
        $_SESSION['user_privs']=$privsId;
        //
        Cookie::set('user_login',$login,Yii::$app->params['authCookieExpire']);
        Cookie::set('user_password',$passHash,Yii::$app->params['authCookieExpire']);
    }

    public function getRoles()
    {
        return $this->hasMany(UsersRoles::class,['id'=>'role_id'])->viaTable('users_roles',['user_id'=>'id']);
    }

    public function getPrivs($refresh=false)
    {
        if(null!==$this->privsMas and !$refresh) return $this->privsMas;
        //
        $this->privsMas=[];
        foreach($this->roles as $Role)
            $this->privsMas=array_merge($this->privsMas,$Role->privs);
        return $this->privsMas;
    }

    static public function logout()
    {
        $_SESSION=[];
        Cookie::delete(session_name());
        Cookie::delete('user_login');
        Cookie::delete('user_password');
        session_destroy();
    }

//    public function scenarios()
//    {
//        //TODO поэксперементировать со сценариями
//        $scenarios=parent::scenarios();
//        $scenarios[static::SCENARIO_CRUD]=['id','surname', 'patronymic', 'first_name', 'login', 'password'];
//        $scenarios[static::SCENARIO_SHOW]=[];
//        return $scenarios;
//    }

    public function rules()
    {
        return [
            //TODO добавить разные правила для разных сценариев (создание, редактирование, удаление и т.п.)
            [ 'id', 'safe', 'on'=>static::SCENARIO_CRUD ],
            [ ['surname', 'patronymic', 'first_name', 'login', 'password', 'salt'], 'required', 'on'=>static::SCENARIO_CRUD ]
        ];
    }
}