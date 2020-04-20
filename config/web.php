<?php

$params = require __DIR__ . '/params.php';
$dbDev = require __DIR__ . '/dbDev.php';

$config = [
    'id' => 'zshop.yii5391',
    'basePath' => dirname(__DIR__),
    //TODO поэксперементировать с добавлением собственного модуля или компонета в раздел начальной загрузки
    'bootstrap' => ['log','app\components\init\InitMain'],
    'aliases' => [
        '@app_translations' => '@app/translations', /*путь до папки с файлами, где храняться тексты переводов*/
        '@log_own' => '@runtime/logs', /*путь до папки, где храняться собственные логи, отличные от логов Yii2*/
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager'=>[
          'appendTimestamp'=>true,
          'converter'=>[
            'class'=>'yii\web\AssetConverter',
            'commands'=>[
                'less'=>['css','lessc {from}  {to} --no-color']
            ],
            'forceConvert'=>YII_ENV_DEV? true : false
          ],
          'bundles'=>[
              'yii\web\JqueryAsset'=>[
                  'js'=> [YII_ENV_DEV? 'jquery.js':'jquery.min.js']
              ]
          ],
          'linkAssets'=>true,
        ],
        'request' => [
            'cookieValidationKey' => 'z19Shp/kLling337.fLor-dSert_eGle',
        ],
        'i18n'=>[
            'translations'=>[
                'app'=>[
                    'class'=>'yii\i18n\PhpMessageSource',
                    'basePath'=>'@app_translations',
                ],
                'userAuthForms'=>[
                    'class'=>'yii\i18n\PhpMessageSource',
                    'basePath'=>'@app_translations',
                ]
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl'=>'deprecated/site/login',
            'enableAutoLogin' => true,
        ],
        'users'=>['class'=>'app\models\Users'],
        'errorHandler' => [
            //TODO изменить обработчик ошибок
            'errorAction' => 'deprecated/site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $dbDev,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'controllerMap'=>[
        //просто сокращение для длинного пути
        'gbc'=>'app\controllers\GoodsByCategoryController'
    ],
    'defaultRoute'=>'categories',
    'language' => 'ru-RU',
    'layout'=>'main_z19',
    'modules'=>[
      'auth'=>[
          'class'=>'app\modules\auth\AuthModule'
      ]
    ],
    'name' => 'Магазинчик у Zeberti19',
    'params' => $params,
    'timeZone' => 'Asia/Yekaterinburg',
    //TODO придумать какой-нить функционал, чтобы использовать параметр version
    'version' => '1.0'
    //'catchAll'=>['notice/message-show','message'=>'Сайт временно не доступен из-за технических работ. Приносим свои извинения.'],
    //======================СОБЫТИЯ=========================================
//    'on beforeRequest' => function($Event){
//        file_put_contents('test.txt', date('Y.m.d H:i:s') .' Проверка события "on beforeRequest"');
//    },
//    'on beforeAction' => function($Event){
//        $Event->isValid=false;
//    },
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
