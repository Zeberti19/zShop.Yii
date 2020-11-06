<?php

namespace app\models;

use app\components\helpers\Cookie;
use app\components\helpers\Encode;
use Exception;
use Yii;
use yii\db\ActiveRecord;

class SpecialUser extends ActiveRecord
{
    /**
     * Сценарий используемый при создании пользователя через раздел "Администрирование"
     */
    const SCENARIO_CREATE_BY_ADMIN='CREATE_BY_ADMIN';

    /**
     * Сценарий используемый при создании пользователя во время его регистрации
     */
    const SCENARIO_CREATE_BY_USER='CREATE_BY_USER';

    /**
     * Сценарий используемый при редактировании пользователя
     */
    const SCENARIO_EDIT='EDIT';

    /**
     * Сценарий используемый при отображении формы авторизации пользователя
     */
    const SCENARIO_LOGIN_FORM='LOGIN';

    /**
     * Сценарий используемый при отображении формы регистрации пользователя
     */
    const SCENARIO_REGISTER_FORM='REGISTER';

    protected $privsMas=null;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->salt=Encode::getSaltNew();
    }

    public function attributeLabels()
    {
        return [ 'id' =>  Yii::t('app','ID'),
                'surname' =>  Yii::t('app','Surname'),
                'first_name' =>  Yii::t('app','First Name'),
                'patronymic' =>  Yii::t('app','Patronymic'),
                'login' =>  Yii::t('app','Login'),
                'password' =>  Yii::t('app','Password'),
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
        if ((!$login and 0 !==$login and '0' !==$login)
            or !$password)
            throw new Exception($errMesPref.'Логин или пароль не указаны ни в параметрах функции "auth", ни в куках',0);
        $User=static::findOne(['login'=>$login]);
        if (!$User) throw new Exception($errMesPref.'Указанный логин не существует',1);
        $passHash=$passwordIsHash? $password : Encode::passwordEncode($password,$User->salt);
        $User=static::findOne(['login'=>$login,'password'=>$passHash]);
        if (!$User) throw new Exception($errMesPref.'Неверный пароль',2);
        $User->sessionSave();
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

    public function scenarios()
    {
        $scenarios=parent::scenarios();
        $scenarios[static::SCENARIO_CREATE_BY_USER]=['surname', 'patronymic', 'first_name', 'login', 'password','!salt'];
        return $scenarios;
    }

    /**
     * Сохраняет данные о пользователе как о текущем активном пользователе в сессию
     */
    public function sessionSave()
    {
        if (session_status() != PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id']=$this->id;
        $_SESSION['user_login']=$this->login;
        $rolesId=[];
        $privsId=[];
        foreach($this->roles as $Role) $rolesId[]=$Role->id;
        foreach($this->privs as $Priv) $privsId[]=$Priv->id;
        $_SESSION['user_roles']=$rolesId;
        $_SESSION['user_privs']=$privsId;
        //
        Cookie::set('user_login',$this->login,Yii::$app->params['authCookieExpire']);
        Cookie::set('user_password',$this->password,Yii::$app->params['authCookieExpire']);
    }

    public function rules()
    {
        return [
            [ ['surname','patronymic','first_name'], 'trim' ],
            [ 'id', 'safe', 'on'=>[static::SCENARIO_CREATE_BY_ADMIN] ],
            [ ['surname', 'patronymic', 'first_name', 'login', 'password', 'salt'], 'required', 'on'=>[static::SCENARIO_CREATE_BY_ADMIN,static::SCENARIO_CREATE_BY_USER,static::SCENARIO_EDIT] ],
            [ ['surname', 'patronymic', 'first_name', 'login', 'password'], 'required', 'on'=>static::SCENARIO_REGISTER_FORM ],
            [ ['login', 'password'], 'required', 'on'=>[static::SCENARIO_LOGIN_FORM] ],
        ];
    }
}
