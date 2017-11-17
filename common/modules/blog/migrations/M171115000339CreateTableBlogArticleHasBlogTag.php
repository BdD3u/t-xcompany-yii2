<?php

namespace common\modules\blog\migrations;

use yii\db\Migration;

/**
 * Class M171115000339CreateTableBlogArticleHasBlogTag
 */
class M171115000339CreateTableBlogArticleHasBlogTag extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_article_has_blog_tag}}', [
            'blog_article_id' => $this->integer()->unsigned()->notNull(),
            'blog_tag_id' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addPrimaryKey('pk', '{{%blog_article_has_blog_tag}}', 'blog_article_id, blog_tag_id');
        $this->addForeignKey(
            'fk_blog_article_has_blog_tag_blog_article1_idx',
            '{{%blog_article_has_blog_tag}}',
            'blog_article_id',
            '{{%blog_article}}',
            'id'
        );
        $this->addForeignKey(
            'fk_blog_article_has_blog_tag_blog_tag1_idx',
            '{{%blog_article_has_blog_tag}}',
            'blog_tag_id',
            '{{%blog_tag}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropPrimaryKey('pk', '{{%blog_article_has_blog_tag}}');
        $this->dropForeignKey('fk_blog_article_has_blog_tag_blog_article1_idx', '{{%blog_article_has_blog_tag}}');
        $this->dropForeignKey('fk_blog_article_has_blog_tag_blog_tag1_idx', '{{%blog_article_has_blog_tag}}');
        $this->dropTable('{{%blog_article_has_blog_tag}}');
    }
}
