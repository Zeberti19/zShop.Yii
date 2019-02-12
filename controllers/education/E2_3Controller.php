<?php

namespace app\controllers\education;

use Yii;
use yii\web\Controller;

class E2_3Controller extends Controller
{
    /**
     * @param string $messageShow
     * @return string
     */
    public function actionMessageShow($messageShow="Иди на хуй!")
    {
        $controllerPath=__FILE__;
        $time=date("H:i:s");
        return $this->render('messageShow', [ "messageShow" => $messageShow, "controllerPath"=>$controllerPath, "time"=>$time ]);
    }
}
