<?php


namespace common\modules\link\behaviors;


use common\modules\link\models\LinkItem;
use yii\base\Behavior;
use yii\web\Application;
use yii\web\HttpException;

class LinkHandler extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest'
        ];
    }

    public function beforeRequest()
    {
        $chkLink = rtrim(\Yii::$app->request->pathInfo, '/');
        $linkItem = null;
        if($chkLink) {
            /** @var LinkItem $linkItem */
            $linkItem = LinkItem::find()->where(['like', 'link', $chkLink])->with('userBalance')->with('user')->limit(1)->one();
        }

        if($linkItem && $linkItem->userBalance) {
            $linkItem->userBalance->balance -= $linkItem->price;
            if(!($linkItem->userBalance->balance >= 0 && $linkItem->userBalance->save())) {
                throw new HttpException(401 ,'Page not found');
            }
        } elseif($linkItem) {
            throw new HttpException(401 ,'Page not found');
        }
    }

}