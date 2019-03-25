<?php

use yii\helpers\Html;

/** @var app\models\education\Auth $AuthModel */
?>
<h1>Форма авторизации</h1>
Вы ввели следующий данные:<br>
<b>Логин</b>: <?= Html::encode($AuthModel->login) ?><br>
<b>Пароль</b>: <?= Html::encode($AuthModel->password) ?><br>
<b>Email</b>: <?= Html::encode($AuthModel->email) ?><br>