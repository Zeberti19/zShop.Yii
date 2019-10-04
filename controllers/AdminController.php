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
    protected $dataViewMas=['self','yii2','gii'];

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
        if('gii'==$dataViewNext)
        {
            header('Location:?r=users-gii');
            exit;
        }
        return $this->actionUsersTableShow($dataViewNext);
    }

    public function actionUserCreate($dataViewId)
    {
        $UserNew=null;
        //
        $mesPref='Сохранение нового пользователя. ';
        if ('self'==$dataViewId)
        {
            $id=Yii::$app->request->get('id');
            $surname=Yii::$app->request->get('surname');
            $firstname=Yii::$app->request->get('first_name');
            $patronymic=Yii::$app->request->get('patronymic');
            $UserNew = new Users(["id" => $id, "surname" => $surname, "first_name" => $firstname, "patronymic" => $patronymic]);
        }
        elseif ('yii2'==$dataViewId)
        {
            $UserNew = new Users();
            $UserNew->load(Yii::$app->request->post());
        }
        //TODO добавить подробный вывод ошибок
        if ( !$UserNew ) throw new \Exception($mesPref.'Объект "Пользователь" (UserNew) не смог быть создан. Сохранение невозможно');
        if ( !$UserNew->validate() ) throw new \Exception($mesPref.'Новосозданный объект "Пользователь" (UserNew) не прощел валидацию параметров. Сохранение отмененно');
        if ( !$UserNew->save(false) ) throw new \Exception($mesPref.'Новосозданный объект "Пользователь" (UserNew) не смог быть сохранен');
        if (!$UserNew->id)
        {
            //TODO убрать костыль, который устанавливает префикс пути изображений до других событий JS
            $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
            //
            //TODO разобраться почему не работает refresh для получения ИД из AUTO INCREMENT
            //$UserNew->refresh();
            //TODO вынести функционал отображения сообщения в общий хелпер
            $messageHtml = 'Создан новый пользователь с <b>ИД:</b> ' . Html::encode($UserNew->id) . '<br>' .
                '<b>Фамиилия:</b> ' . Html::encode($UserNew->surname) . '<br>' .
                '<b>Имя:</b> ' . Html::encode($UserNew->first_name) . '<br>' .
                '<b>Отчество:</b> ' . Html::encode($UserNew->patronymic) . '<br>';
            $messageForJs = str_replace('\"', '\\\"', $messageHtml);
            $this->view->registerJs('ProjectCommon.Message.show("' . $messageForJs . '", true)');
        }
        return $this->actionUsersTableShow($dataViewId);
    }

    public function actionUserDelete($id)
    {
        //TODO добавить подробный вывод ошибок
        if ( !Users::deleteAll(['id' => $id])) return "Возникла ошибка при удалении пользователя";
        return $this->actionUsersTableShow('self');
    }

    public function actionUserEdit($id, $surname, $first_name, $patronymic)
    {
        /**@var yii\db\ActiveRecord $UserEdit */
        $UserEdit = Users::findOne(["id" => $id]);
        $UserEdit->surname = $surname;
        $UserEdit->first_name = $first_name;
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
        $Users = Users::find()->orderBy('surname,first_name,patronymic');
        //
        switch($dataViewId)
        {
            case 'yii2':
                $dataViewName='Yii2 инструменты';
                $UserForm=new Users();
                $dataRender['UserForm']=$UserForm;
                //
                $Pagination=new yii\data\Pagination(['totalCount'=>$Users->count(), 'defaultPageSize'=>10]);
                $Pagination->route='admin';
                $tablePageN=Yii::$app->request->get('page');
                $tablePageN=$tablePageN?$tablePageN:1;
                $dataRender['tablePageN']=$tablePageN;
                $Pagination->params=['page'=>$tablePageN,'dataViewId'=>$dataViewId];
                $dataRender['Pagination']=$Pagination;
                $Users->offset($Pagination->offset)->limit($Pagination->limit);
                break;
            case 'self':
            default:
                $dataViewName='Самодельные инструменты';
        }
        //
        $dataRender['Users']=$Users->all();
        //
        $dataRender['dataViewId']=$dataViewId;
        $dataRender['dataViewName']=$dataViewName;
        $this->view->registerJs('Admin.dataViewId="' .str_replace('"','\"',$dataViewId) .'"');
        //
        return $this->render('index.php', $dataRender);
    }
}