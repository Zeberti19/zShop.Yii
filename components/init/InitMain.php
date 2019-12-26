<?php

namespace app\components\init;

use app\components\helpers\ErrorHandler;
use app\components\helpers\Logging;
use app\models\Users;
use Yii;
use yii\base\BootstrapInterface;
use Exception;

class InitMain implements BootstrapInterface
{
    public function bootstrap($app)
    {
        ErrorHandler::$logPath=\Yii::getAlias('@log_own') .DS .'err_log.log';
        Logging::$logPath=\Yii::getAlias('@log_own') .DS .'app_log_own.log';
        if (session_status() != PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['user_id']) or (is_null($_SESSION['user_id']) and 0!==$_SESSION['user_id'] and '0'!==$_SESSION['user_id']))
            try {Users::auth();}catch(Exception $Exception){};
    }
}