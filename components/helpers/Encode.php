<?php

namespace app\components\helpers;
use \Exception;

class Encode
{
    static public function getSaltNew()
    {
        $lenMax=5+static::getRand(0,5);
        $salt='';
        for($n=0; $n<$lenMax; $n++)
        {
            $salt.=mb_chr(static::getRand(33,126));
        }
        return $salt;
    }

    /**
     * Возвращает криптографически безопасное случайное целое число, если у ОС есть соотвествующая функция, которая может генерировать такие числа.
     * Если у ОС нет такой функции, то вернет обычное случайное число (функция rand()).
     * @param int $min
     *         Минимальное возможное значение случайного числа. По-умолчанию, ноль.
     * @param null|int $max
     *         Максимально возможное значение случайного числа. По-умолчанию, равен результату выполнения функции getrandmax().
     * @return int
     */
    static public function getRand($min=0,$max=null)
    {
        $max=(is_null($max) and 0!==$max and '0'!==$max)?getrandmax():$max;
        try{$number=random_int($min,$max);}catch(Exception $Exception){$number=rand($min,$max);};
        return $number;
    }

    static public function passwordEncode($password,$salt)
    {
        return sha1($password.$salt.PASSWORD_SALT_GLOBAL);
    }
}