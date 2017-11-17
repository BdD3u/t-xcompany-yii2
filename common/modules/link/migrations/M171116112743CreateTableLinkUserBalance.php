<?php

namespace common\modules\link\migrations;

use yii\db\Migration;

/**
 * Class M171116112743CreateTableLinkUserBalance
 */
class M171116112743CreateTableLinkUserBalance extends Migration
{
    public function up()
    {
        $this->createTable('{{%link_user_balance}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'balance' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk_link_user_balance_user1_idx',
            '{{%link_user_balance}}',
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_link_user_balance_user1_idx', '{{%link_user_balance}}');
        $this->dropTable('{{%link_user_balance}}');
    }
}
