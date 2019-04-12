<?php

$params = require __DIR__ . '/params.php';
$dbEducation = require __DIR__ . '/dbEducation.php';
$dbDev = require __DIR__ . '/dbDev.php';

$config = [
    'id' => 'zshop.yii5391',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',],
    'on ' .yii\web\View::EVENT_END_BODY => function(){
        echo '<div style="color: #997622; font-weight: bolder; text-align: left">' .date('H:i:s').'</div>';},
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            //TODO insert a NEW secret key in the following - this is required by cookie validation
            'cookieValidationKey' => 'SF4_wmLxCh2zpwfOkI18tbUwloN59qC3',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'dbEducation' => $dbEducation,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'defaultRoute'=>'main-page',
    'language' => 'ru-RU',
    'name' => 'Магазинчик у Zeberti19',
    'params' => $params,
    'timeZone' => 'Asia/Yekaterinburg',
    //'catchAll'=>['notice/index','message'=>'Проверка функции уведомления'],
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
