<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\GoodsCategory;

class MainPageController extends Controller
{
    public function actionIndex()
    {
        $GoodsCategory=new GoodsCategory();
        $GoodsCategory=$GoodsCategory->find()->all();
        $this->view->registerCssFile('/css/main-page.css');
        $this->view->registerCssFile('/css/blocks/what-interested.css');
        $this->view->registerCssFile('/css/blocks/goods-category.css');
        return $this->render('index',['GoodsCategory'=>$GoodsCategory]);
    }
}