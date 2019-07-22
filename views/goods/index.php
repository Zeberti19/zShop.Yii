<?php
    use yii\helpers\Html;
    /**@var app\models\Goods $Goods*/

    $imagePath=Yii::$app->params['image_prefix'].$Goods->image_path;
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
    <div class="goods goods_page">
        <div class="goods__name goods__name_page"><?= Html::encode( $Goods->name ); ?></div>
        <div class="goods__image-container goods__image-container_page">
            <img src="<?= Html::encode( $imagePath ); ?>" class="goods__image" height="500" width="500">
        </div>
        <div class="goods__buy-container">
            <div class="goods__buy-container-inner">
                <div class="goods__price goods__price_page"><?= Html::encode( $price ); ?> руб</div>
                <button class="goods__buy-button">Купить</button>
            </div>
        </div>
    </div>