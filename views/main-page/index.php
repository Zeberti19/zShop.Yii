<?php
use app\components\helpers\ErrorHandler as Error;
use yii\helpers\Html;

/**@var app\models\CategoryGoods $CategoriesGoods*/
/**@var string $errPrefix*/
?>
<div class="what-interested">Что интересует?</div>
<?php foreach($CategoriesGoods as $Cat)
{
    $catNameEncoded=Html::encode($Cat->name);
    $imagePath=Yii::$app->params['image_prefix'].$Cat->image_path;
    $imageParams=@getimagesize($imagePath);
    //если изображения нет, то ставим изображение по-умолчанию
    if (!$imageParams)
    {
        Error::handle(__FILE__ .':' .__LINE__,'CG_IMG_NF', "{$errPrefix}Не найден файл с изображением категории товаров. ИД категории: {$Cat->id}; Путь до изображения: {$imagePath}" );
        $imagePath=Yii::$app->params['image_prefix'].'empty.png';
        $imageParams=getimagesize($imagePath);
    }
    //если высота изображения больше ширины, то выравниваем изображение по высоте с учетом пропорций. В противном случаи - по ширине
    ($imageParams and $imageParams[1]>$imageParams[0]) ? $imageVerticalIs=true : $imageVerticalIs=false;
?>
    <div class="category-goods" onclick="document.location='?r=goods-by-category&categoryId=<?= str_replace("'", "\\'", Html::encode($Cat->id) ) ?>';">
        <div class="category-goods__image-container">
            <img class="category-goods__image<?=($imageVerticalIs ? ' category-goods__image_vertical' : '')?>"
                 src="<?= Html::encode($imagePath) ?>" alt="Изображение категории товаров &quot;<?= $catNameEncoded ?>&quot;"
                 height="300" width="300"
            >
        </div>
        <div class="category-goods__image-label"><?= $catNameEncoded ?></div>
    </div>
<?php } ?>