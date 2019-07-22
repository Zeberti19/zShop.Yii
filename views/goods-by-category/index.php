<?php
use yii\helpers\Html;
/**@var app\models\Goods $GoodsList*/
/**@var app\models\CategoryGoods $CategoryGoods*/
?>
<h2><?=$CategoryGoods->name?></h2>
<?php foreach($GoodsList as $Goods)
{
    $goodsNameEncoded=Html::encode($Goods->name);
    $imagePath=$Goods->image_path;
    $imageParams=@getimagesize($imagePath);
    //если изображения нет, то ставим изображение по-умолчанию
    if (!$imageParams)
    {
        $imagePath='images/empty.png';
        $imageParams=getimagesize($imagePath);
    }
    //если высота изображения больше ширины, то выравниваем изображение по высоте с учетом пропорций. В противном случаи - по ширине
    ($imageParams and $imageParams[1]>$imageParams[0]) ? $imageVerticalIs=true : $imageVerticalIs=false;
    //форматируем цену
    $price=strripos($Goods->price,'.') ? number_format($Goods->price,2,',', ' ') : number_format($Goods->price,0,',', ' ');
    ?>
    <!--TODO проверить, что ИД с кавычками разных видов доступен для вставки-->
    <div class="goods" onclick="document.location='?r=goods&id=<?= Html::encode($Goods->id); ?>'">
        <div class="goods__image-container">
            <img class="goods__image<?=($imageVerticalIs ? ' goods__image_vertical' : '')?>"
                 src="<?= Html::encode($imagePath) ?>" alt="Изображение категории товаров &quot;<?= $goodsNameEncoded ?>&quot;"
                 height="300" width="300"
            >
        </div>
        <?php //TODO Товары по категории. Добавить "..." в конец названия товара, если его текст полностью не влазит в окошко  ?>
        <div class="goods__name" title="<?= $goodsNameEncoded ?>"><?= $goodsNameEncoded ?></div>
        <div class="goods__price">(<?= $price ?> руб)</div>
    </div>
<?php } ?>