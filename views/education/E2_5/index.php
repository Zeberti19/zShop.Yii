<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
Содержимое таблицы "Country":<br>
<?php
/** @var object[] $CountryModel */
/** @var object $Country */
/** @var yii\data\Pagination $Pagination */
foreach( $CountryModel as $Country ):?>
    <div><?= Html::encode($Country->name) ?></div>
<?php endforeach ?>

<?= LinkPager::widget( ["pagination"=>$Pagination] ) ?>

