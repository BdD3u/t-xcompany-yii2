<?php

namespace common\modules\blog\migrations;

use yii\db\Migration;

/**
 * Class M171115000221CreateTableBlogArticle
 */
class M171115000221CreateTableBlogArticle extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_article}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'code' => $this->string(255)->unique()->notNull(),
            'active' => $this->boolean()->notNull(),
            'title' => $this->string(255)->notNull(),
            'preview_content' => $this->text(),
            'content' => $this->db->driverName === 'mysql' ? 'LONGTEXT' : $this->text(),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->string(255),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'image_id' => $this->integer()->unsigned(),
            'blog_category_id' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_blog_article_image1_idx',
            '{{%blog_article}}',
            'image_id',
            '{{%blog_image}}',
            'id'
        );


        $this->addForeignKey(
            'fk_blog_article_user1_idx',
            '{{%blog_article}}',
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_blog_article_image1_idx', '{{%blog_article}}');
        $this->dropForeignKey('fk_blog_article_user1_idx', '{{%blog_article}}');
        $this->dropTable('{{%blog_article}}');
    }
}
