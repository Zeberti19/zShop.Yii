<?php
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\Users;
use yii\helpers\Html;

class AdminController extends Controller
{

    protected function userTablePrepare()
    {
        $Users = Users::find()->all();
        $this->view->registerCssFile('css/admin.css');
        $this->view->registerCssFile('css/blocks/users-table_admin.css');
        $this->view->registerCssFile('css/blocks/admin-user-create-window.css');
        $this->view->registerCssFile('css/blocks/admin-user-edit-window.css');
        $this->view->registerCssFile('css/blocks/buttons/close-button/close-button.css');
        $this->view->registerCssFile('css/blocks/buttons/text-button/text-button.css');
        $this->view->registerCssFile('css/blocks/view-changer/view-changer.css');
        //TODO подключение общих CSS и JS нужно прописать один раз в одном месте
        $this->view->registerCssFile('css/blocks/message/message.css');
        $this->view->registerJsFile('js/_ProjectCommon/ProjectCommon.js');
        $this->view->registerJsFile('js/_ProjectCommon/Message.js');
        $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
        //
        $this->view->registerJsFile('js/admin/Admin.js');

        return $Users;
    }

    public function actionIndex()
    {
        $Users = $this->userTablePrepare();
        return $this->render('index.php', ['Users' => $Users]);
    }

    public function actionUserCreate($id, $surname, $firstname, $patronymic)
    {
        $UserNew = new Users(["id" => $id, "surname" => $surname, "first_name" => $firstname, "patronymic" => $patronymic]);
        $UserNew->save();
        $Users = $this->userTablePrepare();
        if (!$id)
        {
            //TODO разобраться почему не работает refresh для получения ИД из AUTO INCREMENT
            //$UserNew->refresh();
            //TODO вынести функционал отображения сообщения в общий хелпер
            $messageHtml = 'Создан новый пользователь с <b>ИД:</b> ' . Html::encode($id) . '<br>' .
                '<b>Фамиилия:</b> ' . Html::encode($UserNew->surname) . '<br>' .
                '<b>Имя:</b> ' . Html::encode($UserNew->first_name) . '<br>' .
                '<b>Отчество:</b> ' . Html::encode($UserNew->patronymic) . '<br>';
            $messageForJs = str_replace('\"', '\\\"', $messageHtml);
            $this->view->registerJs('ProjectCommon.Message.show("' . $messageForJs . '", true)');
        }
        return $this->render('index.php', ['Users' => $Users]);
    }

    public function actionUserDelete($id)
    {
        //TODO добавить обработку ошибок
        Users::deleteAll(['id' => $id]);
        $Users = $this->userTablePrepare();
        return $this->render('index.php', ['Users' => $Users]);
    }

    public function actionUserEdit($id, $surname, $firstname, $patronymic)
    {
        /**@var yii\db\ActiveRecord $UserEdit */
        $UserEdit = Users::findOne(["id" => $id]);
        $UserEdit->surname = $surname;
        $UserEdit->first_name = $firstname;
        $UserEdit->patronymic = $patronymic;
        $UserEdit->save();

        return $this->actionIndex();
    }
}