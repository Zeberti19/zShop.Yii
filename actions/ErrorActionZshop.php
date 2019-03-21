<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21.03.2019
 * Time: 18:59
 */

namespace app\actions;

use yii;

class ErrorActionZshop extends yii\web\ErrorAction
{
    /**
     * Builds array of parameters that will be passed to the view.
     * @return array
     * @since 2.0.11
     */
    protected function getViewRenderParams()
    {
        $paramMas=parent::getViewRenderParams();
        $paramMas["new_param"]="Мой новый особый параметр (Тест)";
        return $paramMas;
    }
}