<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersGii */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-gii-form">

    <?php //TODO устранить ошибку: если не указать ИД при создании пользователя, то после создания пользователя перенаправляет на несуществующую страницу?>
    <?php //TODO устранить ошибку: если не указать ИД при редактировании пользователя, то ИД пользователя присваивается значение пустой строки вместо того, чтобы получить ему при помощи AUTO_INCREMENT?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
