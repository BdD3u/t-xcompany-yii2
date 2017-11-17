<?php
//var_dump(get_defined_vars());
//die();
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ]
    ],
    'modules' => [
        'blog' => [
            'class' => common\modules\blog\Module::class,
            'uploadPath' => \Yii::getAlias('@frontend') . '/web/upload/blog-images',
            'uploadWebPath' => 'http://t-shop.dev/upload/blog-images',
            'isBackend' => function() {
                return \Yii::$app->id === 'app-backend';
            },

        ],
//        'link' => [
//            'class' => common\modules\link\LinkModule::class,
//        ]
    ],
];


