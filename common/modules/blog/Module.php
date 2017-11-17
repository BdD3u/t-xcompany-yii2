<?php

namespace common\modules\blog;

/**
 * Class Module
 * @package common\modules\blog
 *
 * Example for configuration...
 *   'modules' => [
 *       'blog' => [
 *           'class' => common\modules\blog\Module::class,
 *           'uploadPath' => \Yii::getAlias('@frontend') . '/web/upload/blog-images',
 *           'uploadWebPath' => 'http://t-shop.dev/upload/blog-images',
 *           'isBackend' => function() {
 *               return \Yii::$app->id === 'app-backend';
 *           },
 *       ],
 *   ],
 */

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\blog\controllers';

    public $uploadPath;
    public $uploadWebPath;
    public $frontendUrl;
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(!($this->uploadPath && is_dir($this->uploadPath))) {
            throw new \Exception('Directory of upload is undefined or not found...');
        }

        if(!$this->uploadWebPath) {
            throw new \Exception('Undefined URI upload directory.');
        }

        if(!($this->isBackend && is_a($this->isBackend, \Closure::class))) {
            throw new \Exception('Function "isBackend" not defined.');
        }

        // switching backend/frontend controllers...
        if(!$this->isBackend->__invoke()) {
            $this->controllerNamespace = 'common\modules\blog\frontend\controllers';
            $this->setViewPath(__DIR__ . '/frontend/views');
        }

    }
}
