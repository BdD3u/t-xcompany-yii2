<?php

namespace common\modules\blog\migrations;

use yii\db\Migration;

/**
 * Class M171115000255CreateTableBlogCategory
 */
class M171115000255CreateTableBlogCategory extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_category}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'code' => $this->string(255)->notNull()->unique(),
            'parent_id' => $this->integer()->unsigned(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->string(255),
            'create_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'user_id' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey(
            'fk_blog_category_user1_idx',
            '{{%blog_category}}',
            'user_id',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey(
            'fk_blog_article_blog_category1_idx',
            '{{%blog_article}}',
            'blog_category_id',
            '{{%blog_category}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_blog_category_user1_idx', '{{%blog_category}}');
        $this->dropForeignKey('fk_blog_article_blog_category1_idx', '{{%blog_article}}');
        $this->dropTable('{{%blog_category}}');
    }
}
