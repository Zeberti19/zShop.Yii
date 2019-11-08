<?php

namespace app\components\helpers;

class ErrorHandler
{
    /**
     * Путь до файла, в который будут записываться собственные логи. Путь устанавливается в классе InitMain.php,
     * во время начальной загрузки
     *
     * @var string
     */
    static public $logPath;

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
        $linePrefix=file_exists(static::$logPath)?"\n":'';
        //TODO добавить проверку на размер файл лога, чтобы чистить его периодически
        file_put_contents( static::$logPath, $linePrefix .date('y.m.d H:i:s') .". Ошибка!\n    Код: " .$code .$errDesc .".\n    Место ошибки: " .$errPath, FILE_APPEND);
    }


}