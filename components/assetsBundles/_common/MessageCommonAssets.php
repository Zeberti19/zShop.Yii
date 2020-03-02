<?php
namespace app\components\assetsBundles\_common;

use yii\web\AssetBundle;

class MessageCommonAssets extends AssetBundle
{
    public $css=['css/blocks/message/message.css'];
    public $js=['js/_ProjectCommon/Message.js'];

    public $depends=['app\components\assetsBundles\_common\ProjectCommonAssets'];
}