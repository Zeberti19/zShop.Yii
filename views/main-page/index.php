<?php
use yii\helpers\Html;
/**@var app\models\GoodsCategory $GoodsCategory*/
?>
<div class="what-interested">Что интересует?</div>
<?php foreach($GoodsCategory as $Cat)
{
    $catNameEncoded=Html::encode($Cat->name);
    $imagePath='images/'.$Cat->image_path;
    $imageParams=@getimagesize($imagePath);
    //если изображения нет, то ставим изображение по-умолчанию
    if (!$imageParams)
    {
        $imagePath='images/empty.png';
        $imageParams=getimagesize($imagePath);
    }
    //если высота изображения больше ширины, то выравниваем изображение по высоте с учетом пропорций. В противном случаи - по ширине
    ($imageParams and $imageParams[1]>$imageParams[0]) ? $imageVerticalIs=true : $imageVerticalIs=false;
?>
    <div class="goods-category">
        <div class="goods-category__image-container">
            <?php ?>
            <img class="goods-category__image<?=($imageVerticalIs ? ' goods-category__image_vertical' : '')?>"
                 src="<?= Html::encode($imagePath) ?>" alt="Изображение категории товаров &quot;<?= $catNameEncoded ?>&quot;"
                 height="300" width="300"
            >
        </div>

        <div class="goods-category__image-label"><?= $catNameEncoded ?></div>
    </div>
<?php } ?>