<?php

namespace app\controllers\education;

use yii;
use yii\web\Controller;
use app\models\education\Auth;

class E2_4Controller extends Controller
{
    /**
     * @return string
     */
    public function actionAuth()
    {
        $AuthModel=new Auth();
        if($AuthModel->load(Yii::$app->request->post()) && $AuthModel->validate())
            return $this->render('authValidated',["AuthModel"=>$AuthModel]);
        else
            return $this->render('auth',["AuthModel"=>$AuthModel]);
    }
}
