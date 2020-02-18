<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 14.02.2020
 * Time: 12:49
 */

namespace app\widgets\UserCreateWindow;


use yii\base\Widget;

class UserCreateWindow extends Widget
{
    public $id;
    public $idHtml;
    public $dataViewId='self';

    public function init()
    {
        parent::init();
        //TODO перенести CSS в отдельную папку с этим виджетом, но быть внимательным, т.к. этот CSS файл используется в 2-х местах
        $this->view->registerCssFile('css/blocks/admin-user-create-window.css');
        $this->view->registerJsFile('js/widgets/UserCreateWindow/UserCreateWindow.js');
        $idJs=str_replace("'","\\'",$this->id);
        if (!$this->idHtml) $this->idHtml=sha1( $this->id );
        $idHtmlJs=str_replace("'","\\'",$this->idHtml);
        $this->view->registerJs(
            "UserCreateWindows['{$idJs}']=ProjectCommon.clone(UserCreateWindow);"
        ."UserCreateWindows['{$idJs}'].id='{$idJs}';"
        ."UserCreateWindows['{$idJs}'].idHtml='{$idHtmlJs}';");
    }

    public function run()
    {
        return $this->render('userCreateWindow',['id'=>$this->id,'idHtml'=>$this->idHtml]);
    }
}