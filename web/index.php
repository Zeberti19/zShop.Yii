<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
//TODO констатну APP_HINT переделать в параметр системы, т.к. предполагается, что в дальнейшем этот параметр можно включать или выключать в интерфейсе пользователя
//Определяет стоит ли отображать различные подсказки для проекта
defined('APP_HINT') or define('APP_HINT', true);

/*Сокращение наименование константы DIRECTORY_SEPARATOR*/
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
