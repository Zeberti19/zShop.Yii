<?php
namespace app\components\assetsBundles\_common;

use yii\web\AssetBundle;

class ProjectCommonAssets extends AssetBundle
{
    public $basePath="@webroot";
    public $baseUrl="@web";

    public $css=["css/blocks/hints/hint_brown.css"];
    public $js=['js/_ProjectCommon/ProjectCommon.js'];
}