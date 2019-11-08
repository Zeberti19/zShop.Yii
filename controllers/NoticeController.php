<?php

namespace app\controllers;

use yii\web\Controller;

class NoticeController extends Controller
{
    public function actionMessageShow($message)
    {
        $messageJs=str_replace("'","\\'",$message);
        //return $this->render('messageShow', ["messageHtml"=>messageHtml]);
        return "<script type='text/javascript'>alert('{$messageJs}')</script>";
    }
}