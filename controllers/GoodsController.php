<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Goods;

class GoodsController extends Controller
{
    public function actionIndex($id)
    {
        $Goods=Goods::findOne($id);
        $this->view->registerCssFile('/css/blocks/goods/goods.css');
        $this->view->registerCssFile('/css/blocks/goods/goods_page.css');
        return $this->render('index',['Goods'=>$Goods]);
    }
}