<?php
/**@var app\models\Users $Users*/
/**@var string|null $userNewId*/
/**@var string|null $messageHtml*/
/**@var string $dataViewId*/
/**@var string $dataViewName*/
/**@var yii\data\Pagination $Pagination*/
/**@var app\models\Users $UserForm*/
/**@var int $tablePageN*/

use app\widgets\UserCreateWindow\UserCreateWindow;
use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

/**@var string $userCreateWindowId*/
$userCreateWindowIdEncoded=str_replace("'","\\'", Html::encode($userCreateWindowId));
?>
<?php //TODO работа с блоками добавлена только для эксперемента, а так они здесь не нужны ?>
<?php if ('yii2'==$dataViewId): ?>
    <?php
    $this->beginBlock('user_create_window_yii2');
    $UserCreateForm=ActiveForm::begin(['action'=>['admin/users/users-tools/user-create', 'dataViewId' => $dataViewId, 'page' => $tablePageN]])
    ?>
    <?= $UserCreateForm->field($UserForm, 'id'); ?>
    <?= $UserCreateForm->field($UserForm, 'surname')->label("Фамилия")->textInput(); ?>
    <?= $UserCreateForm->field($UserForm, 'first_name')->label("Имя")->textInput(); ?>
    <?= $UserCreateForm->field($UserForm, 'patronymic')->label("Отчество")->textInput(); ?>
    <?= $UserCreateForm->field($UserForm, 'login')->label("Логин")->textInput(); ?>
    <?= $UserCreateForm->field($UserForm, 'password')->label("Пароль")->passwordInput(); ?>
    <div class="form-group">
        <?= Html::submitButton('Создать', ['class'=>'btn btn-primary']); ?>
    </div>
    <?php
    ActiveForm::end();
    $this->endBlock();
    //=========================================
    $this->beginBlock('user_table_pagination')
    ?>
    <div class="pagination_users-table-admin-self">
        <?= \yii\widgets\LinkPager::widget(['pagination'=>$Pagination]); ?>
    </div>
<?php
    $this->endBlock();
    endif
?>
<div class="section-admin" ng-app="ZShop" ng-controller="UsersToolsController">
    <h1 class="head1">Администрирование</h1>
    <h2 class="head2">Пользователи</h2>
    <div class="view-changer">
        <!--TODO уточнить как в БЭМ совмещаются разные блоки в одном-->
        <div class="view-changer__text"><span class="view-changer__description">Вид данных: </span>
            "<span class="view-changer__view-name"><?= $dataViewName;?></span>"
        </div>
        <div class="view-changer__button text-button" onclick="Admin.dataViewNext()">Переключить</div>
        <?php if (Yii::$app->params['hints_show']):?>

            <div class="hint hint_brown hint-view-changer view-selected-<?= $dataViewId ?>">
                <div class="hint_brown__arrow hint_brown__arrow_left"></div>
                <div class="hint__text">Переключает способ представления данных пользователей. Причем иногда меняется не только само представление, но и функционал</div>
            </div>
        <?php endif ?>
    </div>
    <div class="view-<?= $dataViewId ?>">
        <div class="users-table-container">
            <table id="users_table_admin" class="users-table_admin">
                <thead>
                <tr class="users-table_admin__row users-table_admin__line_thead users-table_admin__line_before-tools">
                    <th class="users-table_admin__cell">ИД</th>
                    <th class="users-table_admin__cell">Логин</th>
                    <th class="users-table_admin__cell">Фамилия</th>
                    <th class="users-table_admin__cell">Имя</th>
                    <th class="users-table_admin__cell">Отчество</th>
                </tr>
                <tr class="users-table_admin__row users-table_admin__line_tools">
                    <td class="users-table_admin__cell" colspan="3">
                        <span class="users-table_admin__tool"
                            <?php if ('yii2'==$dataViewId):?>
                                onclick="Admin.userCreateWindow.show()"
                            <?php else:?>
                                onclick="UserCreateWindows['<?= $userCreateWindowIdEncoded ?>'].show()"
                            <?php endif?>
                            >
                            Создать
                        </span>
                    </td>
                    <td class="users-table_admin__cell"><span class="users-table_admin__tool" onclick="Admin.userEditWindow.show()">Редактировать</span></td>
                    <td class="users-table_admin__cell"><span class="users-table_admin__tool" onclick="Admin.userDelete()">Удалить</span></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($Users as $n=>$User):?>
                    <tr data-user_id="<?= Html::encode( $User->id ); ?>" class="users-table_admin__row <?= (0==$n)? 'users-table_admin__line_after-tools':'' ?>" onclick="Admin.userTableTrSelect(this)">
                        <td class="users-table_admin__cell users-table_admin__cell_id"><?= Html::encode( $User->id );?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_login"><?= Html::encode( $User->login ); ?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_surname"><?= Html::encode( $User->surname );?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_first_name"><?= Html::encode( $User->first_name );?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_patronymic"><?= Html::encode( $User->patronymic ); ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($this->blocks['user_create_window_yii2'])): ?>
            <div id="admin_user_create_window" class="admin-user-create-window" style="display: none">
                <div class="admin-user-create-window__head">Создание нового пользователя</div>
                <?= $this->blocks['user_create_window_yii2'] ?>
                <img src="<?= Html::encode( Yii::$app->params['image_prefix'].'close-button.png' ) ?>" class="close-button" onclick="Admin.userCreateWindow.close()" alt="Закрыть">
            </div>
        <?php else: ?>
            <?= UserCreateWindow::widget(['id'=>$userCreateWindowId,'dataViewId'=>$dataViewId])?>
        <?php endif ?>
        <div id="admin_user_edit_window" class="admin-user-edit-window" style="display: none">
            <div>Редактирование пользователя с ИД: <span id="admin_user_edit_window_head_id_container" class="admin-user-edit-window__head-for-id"></span></div>
            <?php if ('yii2'==$dataViewId)
            {
                //TODO Добавить объекты Yii2 фреймворка для редактирования пользователя
            }
            else
            { ?>
                <form action="/admin/users/users-tools/user-edit">
                    <input id="admin-user-edit-window__input_id" type="hidden" name="data[id]" value="">
                    <div class="admin-user-edit-window__labels-container">
                        <label for="admin_user_edit_window_surname_field" class="admin-user-edit-window__label">Фамиилия*:</label>
                        <label for="admin_user_edit_window_firstname_field" class="admin-user-edit-window__label">Имя*:</label>
                        <label for="admin_user_edit_window_patronymic_field" class="admin-user-edit-window__label">Отчество*:</label>
                        <label for="admin_user_edit_window_login_field" class="admin-user-edit-window__label">Логин*:</label>
                    </div>
                    <div class="admin-user-edit-window__fields-container">
                        <input id="admin_user_edit_window_surname_field" name="data[surname]" class="admin-user-edit-window__field" type="text">
                        <input id="admin_user_edit_window_firstname_field" name="data[first_name]" class="admin-user-edit-window__field" type="text">
                        <input id="admin_user_edit_window_patronymic_field" name="data[patronymic]" class="admin-user-edit-window__field" type="text">
                        <input id="admin_user_edit_window_login_field" name="data[login]" class="admin-user-edit-window__field" type="text">
                    </div>
                    <div class="admin-user-edit-window__save-button"><input type="submit" name="create" value="Сохранить"></div>
                </form>
            <?php } ?>
            <img src="<?= Html::encode( Yii::$app->params['image_prefix'].'close-button.png' ) ?>" class="close-button" onclick="Admin.userEditWindow.close()" alt="Закрыть">
        </div>
        <?php if (isset($this->blocks['user_table_pagination']))
            echo $this->blocks['user_table_pagination'];
        ?>
    </div>
</div>