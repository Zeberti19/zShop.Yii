<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Auth $AuthModel */
?>
<h1>Форма авторизации</h1>
<?php $Form = ActiveForm::begin() ?>
    <?= $Form->field($AuthModel,"login")->label("Логин")?>
    <?= $Form->field($AuthModel,"password")->label("Пароль")?>
    <div class="form-group">
        <?= Html::submitButton("Войти", ["class"=>"btn btn-primary"]) ?>
    </div>
<?php ActiveForm::end() ?>
