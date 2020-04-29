<?php
use yii\helpers\Html;
/**@var string $id*/
/**@var string $idHtml*/
$idJsEncoded=str_replace( "'", "\\'", Html::encode($id) );
?>
<div id="<?= Html::encode($idHtml)?>" class="admin-user-create-window" style="display: none">
    <div class="admin-user-create-window__head">Создание нового пользователя</div>
    <form action="/admin/users/users-tools/user-create">
        <?php //TODO проверить как поведет себя encode для значения с кавычками ?>
        <input type="hidden" name="dataViewId" value="<?= Html::encode( $this->context->dataViewId ); ?>">
        <div class="admin-user-create-window__labels-container">
            <label for="admin_user_create_window_id_field" class="admin-user-create-window__label">ИД:</label>
            <label for="admin_user_create_window_surname_field" class="admin-user-create-window__label">Фамиилия*:</label>
            <label for="admin_user_create_window_firstname_field" class="admin-user-create-window__label">Имя*:</label>
            <label for="admin_user_create_window_patronymic_field" class="admin-user-create-window__label">Отчество*:</label>
            <label for="admin_user_create_window_login_field" class="admin-user-create-window__label">Логин*:</label>
            <label for="admin_user_create_window_password_field" class="admin-user-create-window__label">Пароль*:</label>
        </div>
        <div class="admin-user-create-window__fields-container">
            <input id="admin_user_create_window_id_field" name="id" class="admin-user-create-window__field" type="text">
            <input id="admin_user_create_window_surname_field" name="surname" class="admin-user-create-window__field" type="text">
            <input id="admin_user_create_window_firstname_field" name="first_name" class="admin-user-create-window__field" type="text">
            <input id="admin_user_create_window_patronymic_field" name="patronymic" class="admin-user-create-window__field" type="text">
            <input id="admin_user_create_window_login_field" name="login" class="admin-user-create-window__field" type="text">
            <input id="admin_user_create_window_password_field" name="password" class="admin-user-create-window__field" type="password">
        </div>
        <div class="admin-user-create-window__create-button"><input type="submit" name="create" value="Создать"></div>
        <div class="admin-user-create-window__comments">
            <div>- символом "*" отмечены обязательные поля для заполения</div>
            <div>- если ИД не указан, то он будет сформирован автоматически и выведен на экран</div>
        </div>
    </form>
    <img src="<?= Html::encode( Yii::$app->params['image_prefix'].'close-button.png' ) ?>" class="close-button" onclick="UserCreateWindows['<?= $idJsEncoded ?>'].close()" alt="Закрыть">
</div>
