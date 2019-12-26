<?php
namespace app\controllers\_common;

use PHPUnit\Framework\Exception;
use yii;
use yii\web\Controller;
use app\models\Users;
use app\components\helpers\Cookie;

class AuthController extends Controller
{
    public $defaultAction='login-form-show';

    public function actionLoginFormShow()
    {
        if ( isset($_SESSION['user_id']) and (!is_null($_SESSION['user_id']) or 0==($_SESSION['user_id'])) ) return $this->goHome();
        $dataRender=[];
        //
        $this->view->registerCssFile('css/blocks/buttons/text-button/text-button.css');
        $this->view->registerCssFile('css/blocks/login-form/login-form.css');
        $this->view->registerJsFile('js/_ProjectCommon/ProjectCommon.js');
        $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
        $UsersForm = new Users(['scenario'=>Users::SCENARIO_CRUD]);
        //
        $dataRender['UserForm']=$UsersForm;
        //
        return $this->render('loginFormShow.php', $dataRender);
    }

    //TODO подумать, что будет если я авторизуюсь 2 раза друг за другом
    public function actionLogin()
    {
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
}