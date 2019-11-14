<?php

namespace app\components\init;

use app\components\helpers\ErrorHandler;
use app\components\helpers\Logging;
use yii\base\BootstrapInterface;

class InitMain implements BootstrapInterface
{
    public function bootstrap($app)
    {
        ErrorHandler::$logPath=\Yii::getAlias('@log_own') .DS .'err_log.log';
        Logging::$logPath=\Yii::getAlias('@log_own') .DS .'app_log_own.log';
    }
}