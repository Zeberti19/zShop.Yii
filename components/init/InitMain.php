<?php

namespace app\components\init;

use yii\base\BootstrapInterface;

class InitMain implements BootstrapInterface
{
    public function bootstrap($app)
    {
        \app\components\helpers\ErrorHandler::$logPath=\Yii::getAlias('@log_own') .DS .'app_log2.log';
    }
}