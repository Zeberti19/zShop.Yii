<?php
/**@var app\models\SpecialUser $UserForm*/

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
?>
<div class="section-auth">
    <h1 class="head1">Авторизация</h1>
        <div class="login-form">
                <div class="login-form__login-part">
                    <?php $UserCreateForm=ActiveForm::begin(['action'=>['_common/auth/login']]) ?>
                    <?= $UserCreateForm->field($UserForm, 'login')->textInput(); ?>
                    <?= $UserCreateForm->field($UserForm, 'password')->passwordInput()?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('userAuthForms','Login'), ['class'=>'btn btn-primary']); ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
                <div class="login-form__register-part">
                    <div>Нет аккаунта? Зарегиструйтесь!</div>
                    <?php $UserRegisterForm=ActiveForm::begin(['action'=>['_common/auth/register-form-show']]) ?>
                        <div class="login-form__register-buttons form-group">
                            <?= Html::submitButton(Yii::t('app','Register'), ['class'=>'btn btn-success']); ?>
                        </div>
                    <?php ActiveForm::end() ?>
                </div>
        </div>
</div>
