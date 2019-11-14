<?php
namespace app\controllers\admin\users;

use app\components\helpers\ErrorHandler;
use app\components\helpers\Logging;
use yii;
use yii\web\Controller;
use app\models\Users;
use yii\helpers\Html;

class UsersToolsController extends Controller
{
    public $defaultAction='users-table-show';

    public function actions()
    {
        return [
            'data-view-next'=>'app\controllers\admin\users\UsersDataViewNextAction'
        ];
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

    /**
     * @param array $data
     *        Всех набор данных, необходимый для редактирования пользователя
     * @return string
     */
    public function actionUserEdit(array $data)
    {
        //TODO не использовать массив данных для передачи новых значений свойств объект, вместо этого передать отдельные параметры
        //В данном случаи, массив данных используется просто для разнообразия, хотя наглядней было бы сделать передачу отдельного параметра для каждого свойства
        $id=$data['id'];
        $surname=$data['surname'];
        $firstname=$data['firstname'];
        $patronymic=$data['patronymic'];
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
        $this->view->registerCssFile('css/admin/admin.css');
        $this->view->registerCssFile('css/blocks/users-table_admin.css');
        $this->view->registerCssFile('css/blocks/admin-user-create-window.css');
        $this->view->registerCssFile('css/blocks/admin-user-edit-window.css');
        $this->view->registerCssFile('css/blocks/buttons/close-button/close-button.css');
        $this->view->registerCssFile('css/blocks/buttons/text-button/text-button.css');
        $this->view->registerCssFile('css/blocks/view-changer/view-changer.css');
        //TODO подключение общих CSS и JS нужно прописать один раз в одном месте
        $this->view->registerCssFile('css/blocks/hints/hint_brown.css');
        $this->view->registerCssFile('css/blocks/message/message.css');
        $this->view->registerJsFile('js/_ProjectCommon/ProjectCommon.js');
        $this->view->registerJsFile('js/_ProjectCommon/Message.js');
        $this->view->registerJs('ProjectCommon.imagePrefix="' . Yii::$app->params['image_prefix'] . '"');
        //
        $this->view->registerJsFile('js/admin/users/UsersTools.js');
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
                $Pagination->route='admin/users/users-tools';
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

    public function beforeAction($Action)
    {
        if (!parent::beforeAction($Action)) return false;
        $mesPref="Администрирование. Пользователи. ";
        switch ($Action->id)
        {
            case 'user-create':
                $dataViewId=Yii::$app->request->get('dataViewId');
                if ('self'==$dataViewId)
                {
                    $id=Yii::$app->request->get('id');
                    $surname=Yii::$app->request->get('surname');
                    $firstname=Yii::$app->request->get('first_name');
                    $patronymic=Yii::$app->request->get('patronymic');
                }
                else
                {
                    $data=Yii::$app->request->post('Users');
                    $id=$data['id'];
                    $surname=$data['surname'];
                    $firstname=$data['first_name'];
                    $patronymic=$data['patronymic'];
                }
                $params=(is_null($id) or ''===$id)? '' : "id={$id}";
                $params.=' surname=' .$surname;
                $params.=' firstname=' .$firstname;
                $params.=' patronymic=' .$patronymic;
                Logging::write("{$mesPref}Получен запрос на создание пользователя. Параметры: {$params}" );
                break;
            case 'user-edit':
                $data=Yii::$app->request->get('data');
                $params=[];
                foreach($data as $key=>$val) $params[]="data[{$key}]={$val}";
                $params=implode(' ', $params);
                Logging::write("{$mesPref}Получен запрос на редактирование пользователя. Параметры: {$params}" );
                break;
            case 'user-delete':
                $params='id=' .Yii::$app->request->get('id');
                Logging::write("{$mesPref}Получен запрос на удаление пользователя. Параметры: {$params}" );
                break;
            default:
        }
        return true;
    }

    public function afterAction($Action,$result)
    {
        $result=parent::afterAction($Action,$result);
        $mesPref="Администрирование. Пользователи. ";
        switch($Action->id)
        {
            case 'user-create':
                Logging::write("{$mesPref}Запрос на создание пользователя обработан без ошибок" );
                break;
            case 'user-edit':
                Logging::write("{$mesPref}Запрос на редактирование пользователя обработан без ошибок" );
                break;
            case 'user-delete':
                Logging::write("{$mesPref}Запрос на удаление пользователя обработан без ошибок" );
                break;
            default:
        }
        return $result;
    }
}