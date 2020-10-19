<?php
namespace app\components\assetsBundles\admin\users;

use yii\web\AssetBundle;

class UsersToolsAngularAssets extends AssetBundle
{
    public $js=['js/angular/app.module.js',
        'js/angular/users-tools/users-tools.module.js',
        'js/angular/users-tools/users-tools.controller.js',
    ];
}