<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\CategoryGoods;

class MainPageController extends Controller
{
    public function actionIndex()
    {
        $errPrefix='Список категорий товаров. ';
        $CategoriesGoods=new CategoryGoods();
        $CategoriesGoods=$CategoriesGoods->find()->all();
        $this->view->registerCssFile('css/main-page.css');
        $this->view->registerCssFile('css/blocks/what-interested.css');
        $this->view->registerCssFile('css/blocks/category-goods.css');
        return $this->render('index',['CategoriesGoods'=>$CategoriesGoods,'errPrefix'=>$errPrefix]);
    }
}