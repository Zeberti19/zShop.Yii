<?php
/**@var app\models\Users $UserForm*/

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
?>
<div class="section-auth">
    <h1 class="head1">Авторизация</h1>
        <div class="login-form">
                <?php $UserCreateForm=ActiveForm::begin(['action'=>['_common/auth/login']]) ?>
                <?= $UserCreateForm->field($UserForm, 'login')->textInput(); ?>
                <?= $UserCreateForm->field($UserForm, 'password')->passwordInput()?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Login'), ['class'=>'btn btn-primary']); ?>
                </div>
                <?php ActiveForm::end() ?>
        </div>
</div>