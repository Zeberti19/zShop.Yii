<?php
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\Users;
use yii\helpers\Html;

class AdminController extends Controller
{

    /**
     * Массив с ИД видов данных о пользователях. В данном массиве важен порядок,
     * т.к. именно исходя из порядка ИД в этом массиве определяется в какой последовательности будут переключаться
     * виды данных
     *
     * @var array
     */
    protected $dataViewMas=['self','yii2'];

    public $defaultAction='users-table-show';

    /**
     * Меняет вид данных на следующий по порядку
     *
     * @param $dataViewId
     *          ИД текущего вида данных
     * @return string
     */
    public function actionDataViewNext($dataViewId)
    {
        $key=array_search($dataViewId,$this->dataViewMas);
        $key++;
        if($key==count($this->dataViewMas)) $dataViewNext=$this->dataViewMas[0];
        else $dataViewNext=$this->dataViewMas[$key];
        return $this->actionUsersTableShow($dataViewNext);
    }

    public function actionUserCreate($id, $surname, $firstname, $patronymic)
    {
        $UserNew = new Users(["id" => $id, "surname" => $surname, "first_name" => $firstname, "patronymic" => $patronymic]);
        //TODO добавить подробный вывод ошибок
        if ( !$UserNew->validate() or !$UserNew->save()) return "Возникла ошибка при сохранении пользователя";
        if (!$id)
        {
            //TODO убрать костыль, который устанавливает префикс пути изображений до других событий JS
            $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
            //
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
        return $this->actionUsersTableShow('self');
    }

    public function actionUserDelete($id)
    {
        Users::deleteAll(['id' => $id]);
        //TODO добавить подробный вывод ошибок
        if ( !Users::deleteAll(['id' => $id])) return "Возникла ошибка при удалении пользователя";
        return $this->actionUsersTableShow('self');
    }

    public function actionUserEdit($id, $surname, $firstname, $patronymic)
    {
        /**@var yii\db\ActiveRecord $UserEdit */
        $UserEdit = Users::findOne(["id" => $id]);
        $UserEdit->surname = $surname;
        $UserEdit->first_name = $firstname;
        $UserEdit->patronymic = $patronymic;
        //TODO добавить подробный вывод ошибок
        if ( !$UserEdit->validate() or !$UserEdit->save()) return "Возникла ошибка при редактировании пользователя";

        return $this->actionUsersTableShow('self');
    }

    /**
     * Отображает таблицу с данными о пользователях и инструментами для их создания, редактирования и прочего
     *
     * @param string $dataViewId
     *          ИД вида представления данных (т.е. данные о пользователях могут быть представлены в разных видах
     *          и с разными инструментами)
     * @return string
     */
    public function actionUsersTableShow($dataViewId='self')
    {
        $dataRender=[];
        //
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
        $Users = Users::find();
        //
        switch($dataViewId)
        {
            case 'yii2':
                $dataViewName='Yii2 инструменты';
                break;
            case 'self':
            default:
                $Pagination=new yii\data\Pagination(['totalCount'=>$Users->count(), 'defaultPageSize'=>10]);
                $Pagination->route='admin';
                $page=Yii::$app->request->get('page');
                $page=$page?$page:1;
                $Pagination->params=['page'=>$page];
                $dataRender['Pagination']=$Pagination;
                $Users->offset($Pagination->offset)->limit($Pagination->limit);
                $dataViewName='Самодельные инструменты';
        }
        $dataRender['Users']=$Users->all();
        //
        $dataRender['dataViewId']=$dataViewId;
        $dataRender['dataViewName']=$dataViewName;
        $this->view->registerJs('Admin.dataViewId="' .str_replace('"','\"',$dataViewId) .'"');
        //
        return $this->render('index.php', $dataRender);
    }
}