<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'id'                  => 'app-backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [
        'gridview' => [
            'class' => \kartik\grid\Module::className(),
        ],
        'admin'    => [
            'class' => 'mdm\admin\Module',
        ],
        'gii'      => [
            'class'      => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.*'],
        ],
        'debug'    => [
            'class'      => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.*'],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'  => [
            'class'        => 'yii\rbac\DbManager',
        ]
    ],
];
