<?php

namespace app\components\helpers;


class ErrorHandler
{
    /**
     * @param string $errPath
     *          Путь для файла, где возникла ошибка, а также до строчки, где она возникла
     * @param string $code
     * @param string $errDesc
     */
    static public function handle($errPath,$code='',$errDesc='')
    {
        $code=$code?$code:'Не указан';
        $errDesc=$errDesc?".\n    Описание: " .$errDesc :'';
        $logName=\Yii::getAlias('@app') .DS .'runtime' .DS .'logs' .DS .'app_log2.log';
        $linePrefix=file_exists($logName)?"\n":'';
        //TODO добавить проверку на размер файл лога, чтобы чистить его периодически
        file_put_contents( $logName, $linePrefix .date('y.m.d H:i:s') .". Ошибка!\n    Код: " .$code .$errDesc .".\n    Место ошибки: " .$errPath, FILE_APPEND);
    }
}