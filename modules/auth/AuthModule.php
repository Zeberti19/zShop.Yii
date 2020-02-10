<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.02.2020
 * Time: 12:22
 */

namespace app\modules\auth;


class AuthModule extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        //TODO разобраться с namespace, поэксперементировав с соответсвующими параметрами
        \Yii::configure($this,require __DIR__ .'/config.php');
    }
}