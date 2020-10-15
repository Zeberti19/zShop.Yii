<?php
namespace app\components\assetsBundles;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAssets extends AssetBundle
{
    public $sourcePath="@bower";

    public $js=[
        "angular/angular.js",
        "angular/angular-route.js",
    ];

    public $jsOptions=[
        'position'=>View::POS_HEAD
    ];

}