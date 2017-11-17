<?php

namespace common\modules\blog\migrations;

use yii\db\Migration;

/**
 * Class M171115000213CreateTableBlogImage
 */
class M171115000213CreateTableBlogImage extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_image}}',[
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'title' => $this->string(255),
            'origin_name' => $this->string(255)->notNull(),
            'name' => $this->char(36)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%blog_image}}');
    }
}
