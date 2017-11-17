<?php
namespace common\modules\blog\frontend\assets;


use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/source';

    public $publishOptions = [
        'forceCopy' => true
    ];

    public $css = [
       'css/main.css',
    ];

    public $js = [

    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}