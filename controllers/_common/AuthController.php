<?php
namespace app\controllers\_common;

use PHPUnit\Framework\Exception;
use yii;
use yii\web\Controller;
use app\models\Users;
use app\components\helpers\Encode;

class AuthController extends Controller
{
    public $defaultAction='login-form-show';

    public function actionLoginFormShow()
    {
        if ( isset($_SESSION['user_id']) ) return $this->goHome();
        $dataRender=[];
        //
        $this->view->registerCssFile('css/blocks/buttons/text-button/text-button.css');
        $this->view->registerCssFile('css/blocks/login-form/login-form.css');
        $this->view->registerJsFile('js/_ProjectCommon/ProjectCommon.js');
        $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
        $UsersForm = new Users(['scenario'=>Users::SCENARIO_LOGIN_FORM]);
        //
        $dataRender['UserForm']=$UsersForm;
        //
        return $this->render('loginFormShow.php', $dataRender);
    }

    //TODO подумать, что будет если я авторизуюсь 2 раза друг за другом
    public function actionLogin()
    {
        if ( isset($_SESSION['user_id'])) return $this->goHome();
        $mesPref='Авторизация. ';
        try
        {
            $postData=Yii::$app->request->post('Users');
            Users::auth($postData['login'],$postData['password'],false);
        }
        catch(Exception $Exception)
        {
            if (in_array( $Exception->getCode(), [0,1,2] ) ) throw new Exception($mesPref.'Неверный логин или пароль',0);
            else throw $Exception;
        }
        //
        return $this->goHome();
    }

    public function actionLogout()
    {
        Users::logout();
        return $this->goHome();
    }

    public function actionRegister()
    {
        if ( isset($_SESSION['user_id'])) return $this->goHome();
        $mesPref='Регистрация нового пользователя. ';
        //
        $UserNew=new Users(['scenario'=>Users::SCENARIO_CREATE_BY_USER]);
        $UserNew->load(Yii::$app->request->post());
        if ( !$UserNew->validate() )
        {
            $errorsMes=implode(" ", $UserNew->getErrorSummary(true));
            throw new \Exception($mesPref.'Новосозданный объект "Пользователь" (UserNew) не прощел валидацию параметров. Сохранение отмененно. Описание ошибок: ' .$errorsMes);
        }
        $UserNew->salt=Encode::getSaltNew();
        $UserNew->password=Encode::passwordEncode($UserNew->password,$UserNew->salt);
        if ( !$UserNew->save(false) ) throw new \Exception($mesPref.'Новосозданный объект "Пользователь" (UserNew) не смог быть сохранен');
        $UserNew->sessionSave();
        //
        return $this->goHome();
    }

    public function actionRegisterFormShow()
    {
        if ( isset($_SESSION['user_id']) ) return $this->goHome();
        $dataRender=[];
        //
        $this->view->registerCssFile('css/blocks/buttons/text-button/text-button.css');
        $this->view->registerCssFile('css/blocks/register-form/register-form.css');
        $this->view->registerJsFile('js/_ProjectCommon/ProjectCommon.js');
        $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
        //
        $UsersForm = new Users(['scenario'=>Users::SCENARIO_REGISTER_FORM]);
        $dataRender['UserForm']=$UsersForm;
        //
        return $this->render('registerFormShow.php',$dataRender);
    }
}