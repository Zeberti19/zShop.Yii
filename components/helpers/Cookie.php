<?php

namespace app\components\helpers;

class Cookie
{
    //TODO заполнить документацию
    /**
     * Создает или обновляет куки
     *
     * @param string $name
     * @param string $value
     * @param int $cookieExpire
     * @param null|string $path
     *          Если не указан, то берется из результата session_get_cookie_params()
     * @param null|string $domain
     * @param null|string $secure
     * @param null|string $httpOnly
     */
    static public function set($name,$value,$cookieExpire,$path=null,$domain=null,$secure=null,$httpOnly=null)
    {
        $params = session_get_cookie_params();
        $path=$path?$path:$params["path"];
        $domain=$domain?$domain:$params["domain"];
        $secure=$secure?$secure:$params["secure"];
        $httpOnly=$httpOnly?$httpOnly:$params["httponly"];
        setcookie($name, $value, time()+$cookieExpire, $path, $domain, $secure, $httpOnly);
    }

    //TODO проверить, что будет, если попытаться удалить куки с другими параметрами
    /**
     * @param string $name
     * @param null|string $path
     *          Если не указан, то берется из результата session_get_cookie_params()
     * @param null|string $domain
     * @param null|string $secure
     * @param null|string $httpOnly
     */
    static public function delete($name,$path=null,$domain=null,$secure=null,$httpOnly=null)
    {
        $params = session_get_cookie_params();
        $path=$path?$path:$params["path"];
        $domain=$domain?$domain:$params["domain"];
        $secure=$secure?$secure:$params["secure"];
        $httpOnly=$httpOnly?$httpOnly:$params["httponly"];
        setcookie($name, '', time()-1, $path, $domain, $secure, $httpOnly);
    }
}