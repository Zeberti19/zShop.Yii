<?php

namespace app\controllers\education;

use Yii;
use yii\web\Controller;

class E3_7_6Controller extends Controller
{
    public function actions()
    {
        return [
            "static_pages"=>[
                "class"=>'yii\web\ViewAction',
                "viewPrefix"=>'static_pages'
            ],
        ];
    }
}
