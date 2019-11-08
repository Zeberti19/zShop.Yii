<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsersGii */

$this->title = 'Редактирование пользователя с ИД ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователь (ИД=' .$model->id .')', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="users-gii-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
