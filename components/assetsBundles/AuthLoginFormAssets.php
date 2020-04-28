<?php
namespace app\components\assetsBundles;

use yii\web\AssetBundle;

class AuthLoginFormAssets extends AssetBundle
{
    public $basePath="@webroot";
    public $baseUrl="@web";

    public $css=['css/blocks/buttons/text-button/text-button.css','css/blocks/login-form/login-form.less'];
}