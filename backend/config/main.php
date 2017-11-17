<?php

use common\models\User;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'ru',
    'bootstrap' => ['log'],
    'name' => 'T-Admin',
//    'modules' => [
//            'blog' => [
//                'class' => common\modules\blog\Module::class,
//                'defaultRoute' => 'default/index',
//                'uploadPath' => \Yii::getAlias('@frontend') . '/web/upload/blog-images',
//                'uploadWebPath' => 'http://t-shop.dev/upload/blog-images'
//            ],
//    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => [User::ROLE_DASHBOARD],
            'access' => [],
            'root' => [
                'baseUrl'=>'http://t-shop.dev',
                'basePath'=>\Yii::getAlias('@frontend') . '/web',
                'path' => 'upload/global',
                'name' => 'Global'
            ],
//            'watermark' => [
//                'source'         => __DIR__.'/logo.png', // Path to Water mark image
//                'marginRight'    => 5,          // Margin right pixel
//                'marginBottom'   => 5,          // Margin bottom pixel
//                'quality'        => 95,         // JPEG image save quality
//                'transparency'   => 70,         // Water mark image transparency ( other than PNG )
//                'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
//                'targetMinPixel' => 200         // Target image minimum pixel size
//            ]
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        ///*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'formatter' => [
            'datetimeFormat' => 'php:Y-m-d H:i:s',
        ],
        //*/
    ],
//    'as access' => [
//        'class' => 'yii\filters\AccessControl',
//        'except' => ['site/login', 'site/error'],
//        'rules' => [
//            [
//                'allow' => true,
//                'roles' => [User::ROLE_DASHBOARD],
//            ],
//        ],
//        'denyCallback'  =>  function($rule, $action)
//        {
//            if(Yii::$app->user->isGuest) {
//                Yii::$app->getResponse()->redirect('/site/login')->send();
//                die();
//            }
//            throw new ForbiddenHttpException('Доступ запрещен.');
//        },
//    ],
    'as GlobalAccess'=>[
        'class'=> \common\behaviors\GlobalAccessBehavior::class,
        'denyCallback'  =>  function($rule, $action)
        {
            if(Yii::$app->user->isGuest) {
                Yii::$app->getResponse()->redirect('/site/login')->send();
                die();
            }
            throw new ForbiddenHttpException('Доступ запрещен.');
        },
        'rules'=>[
            [
                'controllers'=>['user'],
                'allow' => true,
                'roles' => [User::ROLE_ADMIN],
            ],
            [
                'controllers'=>['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => [User::ROLE_DASHBOARD],
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
        ],
    ],
    'modules' => [
        'link' => [
            'class' => common\modules\link\LinkModule::class,
        ]
    ],

    'params' => $params,
];
