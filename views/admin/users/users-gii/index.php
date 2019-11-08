<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersGiiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="users-gii-index section-admin">

    <h1 class="head1">Администрирование</h1>
    <h2 class="head2"><?= Html::encode($this->title) ?></h2>
    <div class="view-changer">
        <!--TODO уточнить как в БЭМ совмещаются разные блоки в одном-->
        <div class="view-changer__text"><span class="view-changer__description">Вид данных: </span>
            "<span class="view-changer__view-name">Yii2 Gii инструменты</span>"
        </div>
        <div class="view-changer__button text-button" onclick="UsersGii.Controller.dataTypeChange()">Переключить</div>
        <?php if (APP_HINT):?>
            <div class="hint hint_brown hint-view-changer view-selected-gii">
                <div class="hint_brown__arrow hint_brown__arrow_left"></div>
                <div class="hint__text">Переключает способ представления данных пользователей. Причем иногда меняется не только само представление, но и функционал</div>
            </div>
        <?php endif ?>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'surname',
            'first_name',
            'patronymic',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
