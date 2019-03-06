<?php

namespace app\controllers;

use yii\web\Controller;

class NoticeController extends Controller
{
    /**
     * Показывает уведомление
     *
     * @param string $message
     *        Текст уведомления
     * @return string
     */
    public function actionIndex( $message )
    {
        return $this->render('index', ["message"=>$message]);
    }
}
