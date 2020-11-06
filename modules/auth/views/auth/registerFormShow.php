<?php
/**@var app\models\SpecialUser $UserForm*/

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
?>
<div class="section-auth">
    <h1 class="head1">Регистрация</h1>
        <div class="register-form">
                <?php $UserCreateForm=ActiveForm::begin(['action'=>['_common/auth/register']]) ?>
                <?= $UserCreateForm->field($UserForm, 'surname')->textInput(); ?>
                <?= $UserCreateForm->field($UserForm, 'first_name')->textInput(); ?>
                <?= $UserCreateForm->field($UserForm, 'patronymic')->textInput(); ?>
                <?= $UserCreateForm->field($UserForm, 'login')->textInput(); ?>
                <?= $UserCreateForm->field($UserForm, 'password')->passwordInput(); ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('userAuthForms','Register'), ['class'=>'btn btn-primary']); ?>
                </div>
                <?php ActiveForm::end() ?>
        </div>
</div>
