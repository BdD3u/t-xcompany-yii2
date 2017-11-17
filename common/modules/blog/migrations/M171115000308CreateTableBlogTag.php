<?php

namespace common\modules\blog\migrations;

use yii\db\Migration;

/**
 * Class M171115000308CreateTableBlogTag
 */
class M171115000308CreateTableBlogTag extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_tag}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%blog_tag}}');
    }
}
