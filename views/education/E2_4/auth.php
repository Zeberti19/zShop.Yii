<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\education\Auth $AuthModel */
/** @var yii\web\View $this */
/** @var app\controllers\education\E2_4Controller $Context */
$Context=$this->context;
?>
<h1>Форма авторизации (ID контроллера: <?= $Context->id; ?>)</h1>
<?php $Form = ActiveForm::begin() ?>
    <!--?//= $Form->field($AuthModel,"login")->label("Логин")?-->
    <!--?//= $Form->field($AuthModel,"password")->label("Пароль")?-->
    <?= $Form->field($AuthModel,"login")?>
    <?= $Form->field($AuthModel,"password")?>
    <?= $Form->field($AuthModel,"email")?>
    <div class="form-group">
        <?= Html::submitButton("Войти", ["class"=>"btn btn-primary"]) ?>
    </div>
<?php ActiveForm::end() ?>
