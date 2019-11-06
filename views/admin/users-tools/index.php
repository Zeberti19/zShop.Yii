<?php
    /**@var app\models\Users $Users*/
    /**@var string|null $userNewId*/
    /**@var string|null $messageHtml*/
    /**@var string $dataViewId*/
    /**@var string $dataViewName*/
    /**@var yii\data\Pagination $Pagination*/
    /**@var app\models\Users $UserForm*/
    /**@var int $tablePageN*/

    use yii\helpers\Html;
    use \yii\bootstrap\ActiveForm;
?>
<div class="section-admin">
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
                    <th class="users-table_admin__cell">Фамилия</th>
                    <th class="users-table_admin__cell">Имя</th>
                    <th class="users-table_admin__cell">Отчество</th>
                </tr>
                <tr class="users-table_admin__row users-table_admin__line_tools">
                    <td class="users-table_admin__cell" colspan="2"><span class="users-table_admin__tool" onclick="Admin.userCreateWindow.show()">Создать</span></td>
                    <td class="users-table_admin__cell"><span class="users-table_admin__tool" onclick="Admin.userEditWindow.show()">Редактировать</span></td>
                    <td class="users-table_admin__cell"><span class="users-table_admin__tool" onclick="Admin.userDelete()">Удалить</span></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($Users as $n=>$User):?>
                    <tr data-user_id="<?= Html::encode( $User->id ); ?>" class="users-table_admin__row <?= (0==$n)? 'users-table_admin__line_after-tools':'' ?>" onclick="Admin.userTableTrSelect(this)">
                        <td class="users-table_admin__cell users-table_admin__cell_id"><?= Html::encode( $User->id );?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_surname"><?= Html::encode( $User->surname );?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_first_name"><?= Html::encode( $User->first_name );?></td>
                        <td class="users-table_admin__cell users-table_admin__cell_patronymic"><?= Html::encode( $User->patronymic ); ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div id="admin_user_create_window" class="admin-user-create-window" style="display: none">
            <div>Создание нового пользователя</div>
            <?php if ('yii2'==$dataViewId): ?>
                <?php $UserCreateForm=ActiveForm::begin(['action'=>['admin/users-tools/user-create', 'dataViewId' => $dataViewId, 'page' => $tablePageN]]) ?>
                    <?= $UserCreateForm->field($UserForm, 'id')->label("ИД"); ?>
                    <?= $UserCreateForm->field($UserForm, 'surname')->label("Фамилия"); ?>
                    <?= $UserCreateForm->field($UserForm, 'first_name')->label("Имя"); ?>
                    <?= $UserCreateForm->field($UserForm, 'patronymic')->label("Отчество"); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Создать', ['class'=>'btn btn-primary']); ?>
                    </div>
                <?php ActiveForm::end() ?>
            <?php else: ?>
                <form action="/">
                    <input type="hidden" name="r" value="admin/users-tools/user-create">
                    <?php //TODO проверить как поведет себя encode для значения с кавычками ?>
                    <input type="hidden" name="dataViewId" value="<?= Html::encode( $dataViewId ); ?>">
                    <div class="admin-user-create-window__label-container"
                        ><label for="admin_user_create_window_id_field" class="admin-user-create-window__label">ИД:<input id="admin_user_create_window_id_field" name="id" class="admin-user-create-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-create-window__label-container">
                        <label for="admin_user_create_window_surname_field" class="admin-user-create-window__label">Фамиилия*:<input id="admin_user_create_window_surname_field" name="surname" class="admin-user-create-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-create-window__label-container">
                        <label for="admin_user_create_window_firstname_field" class="admin-user-create-window__label">Имя*:<input id="admin_user_create_window_firstname_field" name="first_name" class="admin-user-create-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-create-window__label-container">
                        <label for="admin_user_create_window_patronymic_field" class="admin-user-create-window__label">Отчество*:<input id="admin_user_create_window_patronymic_field" name="patronymic" class="admin-user-create-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-create-window__create-button"><input type="submit" name="create" value="Создать"></div>
                    <div class="admin-user-create-window__comments">
                        <div>- символом "*" отмечены обязательные поля для заполения</div>
                        <div>- если ИД не указан, то он будет сформирован автоматически и выведен на экран</div>
                    </div>
                </form>
            <?php endif ?>
            <img src="<?= Html::encode( Yii::$app->params['image_prefix'].'close-button.png' ) ?>" class="close-button" onclick="Admin.userCreateWindow.close()" alt="Закрыть">
        </div>
        <div id="admin_user_edit_window" class="admin-user-edit-window" style="display: none">
            <div>Редактирование пользователя с ИД: <span id="admin_user_edit_window_head_id_container" class="admin-user-edit-window__head-for-id"></span></div>
            <?php if ('yii2'==$dataViewId)
            {
                //TODO Добавить объекты Yii2 фреймворка для редактирования пользователя
            }
            else
            { ?>
                <form action="/">
                    <input type="hidden" name="r" value="admin/users-tools/user-edit">
                    <input id="admin-user-edit-window__input_id" type="hidden" name="id" value="">
                    <div class="admin-user-edit-window__label-container">
                        <label for="admin_user_edit_window_surname_field" class="admin-user-edit-window__label">Фамиилия:<input id="admin_user_edit_window_surname_field" name="surname" class="admin-user-edit-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-edit-window__label-container">
                        <label for="admin_user_edit_window_firstname_field" class="admin-user-edit-window__label">Имя:<input id="admin_user_edit_window_firstname_field" name="first_name" class="admin-user-edit-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-edit-window__label-container">
                        <label for="admin_user_edit_window_patronymic_field" class="admin-user-edit-window__label">Отчество:<input id="admin_user_edit_window_patronymic_field" name="patronymic" class="admin-user-edit-window__field" type="text"></label>
                    </div>
                    <div class="admin-user-edit-window__save-button"><input type="submit" name="create" value="Сохранить"></div>
                </form>
            <?php } ?>
            <img src="<?= Html::encode( Yii::$app->params['image_prefix'].'close-button.png' ) ?>" class="close-button" onclick="Admin.userEditWindow.close()" alt="Закрыть">
        </div>
        <?php if ('yii2'==$dataViewId): ?>
            <div class="pagination_users-table-admin-self">
                <?= \yii\widgets\LinkPager::widget(['pagination'=>$Pagination]); ?>
            </div>
        <?php endif ?>
    </div>
</div>