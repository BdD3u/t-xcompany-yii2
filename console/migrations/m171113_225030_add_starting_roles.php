<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m171113_225030_add_starting_roles
 */
class m171113_225030_add_starting_roles extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        Yii::$app->getAuthManager()->removeAll();

        $user = Yii::$app->getAuthManager()->createRole(User::ROLE_USER);
        Yii::$app->getAuthManager()->add($user);

        $dashboard = Yii::$app->getAuthManager()->createRole(User::ROLE_DASHBOARD);
        Yii::$app->getAuthManager()->add($dashboard);
        Yii::$app->getAuthManager()->addChild($dashboard, $user);

        $manager = Yii::$app->getAuthManager()->createRole(User::ROLE_MANAGER);
        Yii::$app->getAuthManager()->add($manager);
        Yii::$app->getAuthManager()->addChild($manager, $dashboard);

        $admin = Yii::$app->getAuthManager()->createRole(User::ROLE_ADMIN);
        Yii::$app->getAuthManager()->add($admin);
        Yii::$app->getAuthManager()->addChild($admin, $manager);

        $adminUser = User::find()->where(['username' => 'admin'])->limit(1)->one();

        if($admin) {
            Yii::$app->getAuthManager()->assign($admin, $adminUser->id);
        } else {
            throw new Exception('Could not found user admin.');
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        Yii::$app->getAuthManager()->remove(Yii::$app->getAuthManager()->getRole(User::ROLE_ADMINISTRATOR));
        Yii::$app->getAuthManager()->remove(Yii::$app->getAuthManager()->getRole(User::ROLE_MANAGER));
        Yii::$app->getAuthManager()->remove(Yii::$app->getAuthManager()->getRole(User::ROLE_DASHBOARD));
        Yii::$app->getAuthManager()->remove(Yii::$app->getAuthManager()->getRole(User::ROLE_USER));
    }
}
