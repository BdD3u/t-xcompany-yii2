<?php

namespace common\modules\link\migrations;

use yii\db\Migration;

/**
 * Class M171116112737CreateTableLinkItem
 */
class M171116112737CreateTableLinkItem extends Migration
{
    public function up()
    {
        $this->createTable('{{%link_item}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'link' => $this->string(255)->unique()->notNull(),
            'price' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk_link_item_user1_idx',
            '{{%link_item}}',
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_link_item_user1_idx', '{{%link_item}}');
        $this->dropTable('{{%link_item}}');
    }
}
