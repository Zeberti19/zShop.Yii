<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

/** @var string $controllerPath */
/** @var string $time */
/** @var string $messageShow */
?>
Сообщение от контроллера "<?php echo $controllerPath ?>" (<?php echo $time ?>)<br>
:<br>
<?php echo Html::encode($messageShow); ?>