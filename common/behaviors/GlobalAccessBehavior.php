<?php
namespace common\behaviors;


use yii\base\Behavior;
use yii\base\Controller;
use Yii;

class GlobalAccessBehavior extends Behavior
{
    /**
     * @var array
     * @see \yii\filters\AccessControl::rules
     */
    public $rules = [];

    public $accessControlFilter = \yii\filters\AccessControl::class;
    public $denyCallback;

    /**
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    public function beforeAction()
    {
        Yii::$app->controller->attachBehavior('access', [
            'class' => $this->accessControlFilter,
            'denyCallback' => $this->denyCallback,
            'rules'=> $this->rules
        ]);
    }
}