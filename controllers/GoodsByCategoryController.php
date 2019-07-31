<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\CategoryGoods;

class GoodsByCategoryController extends Controller
{
    public function actionIndex($categoryId)
    {
        $CategoryGoods=CategoryGoods::findOne($categoryId);
        $GoodsList=$CategoryGoods->goods;
        $this->view->registerCssFile('css/goods-by-category.css');
        $this->view->registerCssFile('css/blocks/goods/goods.css');
        return $this->render('index.php',['CategoryGoods'=>$CategoryGoods,
                                          'GoodsList'=>$GoodsList]);
    }
}