<?php

use yii\db\Migration;

/**
 * Class m171113_224909_create_first_user
 */
class m171113_224909_create_first_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            $timestamp = new \yii\db\Expression('UNIX_TIMESTAMP()');
        } else {
            $timestamp = time();
        }


        $this->db->createCommand()->insert('{{%user}}', [
            'username' => 'admin',
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'admin@t-shop.dev',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ])->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
    }
}
