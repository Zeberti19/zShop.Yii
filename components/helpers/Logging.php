<?php

namespace app\components\helpers;

class Logging
{
    /**
     * Путь до файла, в который будут записываться собственные логи. Путь устанавливается в классе InitMain.php,
     * во время начальной загрузки приложения
     *
     * @var string
     */
    static public $logPath;

    /**
     * Запись произвольного сообщения в собственный лог
     *
     * @param string $message
     *          Сообщение
     */
    static public function write($message)
    {
        if (!\Yii::$app->params['logging_own_enable']) return;
        $linePrefix=file_exists(static::$logPath)?"\n":'';
        //TODO добавить проверку на размер файл лога, чтобы чистить его периодически
        file_put_contents( static::$logPath, $linePrefix .date('y.m.d H:i:s') .' ' .$message, FILE_APPEND);
    }
}