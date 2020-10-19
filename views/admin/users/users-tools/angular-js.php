<?php
/**@var string $dataViewId*/
/**@var string $dataViewName*/
use yii\helpers\Html;
?>
<div class="section-admin" ng-app="ZShop" ng-controller="UsersToolsController">
    <h1 class="head1">Администрирование</h1>
    <h2 class="head2">Пользователи</h2>
    <div class="view-changer">
        <!--TODO уточнить как в БЭМ совмещаются разные блоки в одном-->
        <div class="view-changer__text"><span class="view-changer__description">Вид данных: </span>
            "<span class="view-changer__view-name"><?= $dataViewName;?></span>"
        </div>
        <div class="view-changer__button text-button" onclick="Admin.dataViewNext()">Переключить</div>
        <?php if (Yii::$app->params['hints_show']):?>
            <div class="hint hint_brown hint-view-changer view-selected-<?= $dataViewId ?>">
                <div class="hint_brown__arrow hint_brown__arrow_left"></div>
                <div class="hint__text">Переключает способ представления данных пользователей. Причем иногда меняется не только само представление, но и функционал</div>
            </div>
        <?php endif ?>
    </div>
    <div class="view-<?= $dataViewId ?>">
        <div ng-hide="userMas">
            Данные загружаются...
        </div>
        <div class="users-table-container" ng-show="userMas">
            <table id="users_table_admin" class="users-table_admin">
                <thead>
                    <tr class="users-table_admin__row users-table_admin__line_thead users-table_admin__line_before-tools">
                        <th class="users-table_admin__cell">ИД</th>
                        <th class="users-table_admin__cell">Логин</th>
                        <th class="users-table_admin__cell">Фамилия</th>
                        <th class="users-table_admin__cell">Имя</th>
                        <th class="users-table_admin__cell">Отчество</th>
                    </tr>
                    <tr class="users-table_admin__row users-table_admin__line_tools">
                        <td class="users-table_admin__cell" colspan="3">
                            <span class="users-table_admin__tool"
                                    onclick="alert('В разработке')"
                                >
                                Создать
                            </span>
                        </td>
                        <td class="users-table_admin__cell"><span class="users-table_admin__tool" onclick="alert('В разработке')">Редактировать</span></td>
                        <td class="users-table_admin__cell"><span class="users-table_admin__tool" onclick="alert('В разработке')">Удалить</span></td>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="(n, userData) in userMas" ng-attr-data-user_id="{{userData.id}}" class="users-table_admin__row" ng-class="(0==n)? 'users-table_admin__line_after-tools' : ''" onclick="alert('В разработке')">
                        <td class="users-table_admin__cell users-table_admin__cell_id">{{userData.id}}</td>
                        <td class="users-table_admin__cell users-table_admin__cell_login">{{userData.login}}</td>
                        <td class="users-table_admin__cell users-table_admin__cell_surname">{{userData.surname}}</td>
                        <td class="users-table_admin__cell users-table_admin__cell_first_name">{{userData.first_name}}</td>
                        <td class="users-table_admin__cell users-table_admin__cell_patronymic">{{userData.patronymic}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

