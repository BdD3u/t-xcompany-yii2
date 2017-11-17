<?php

namespace common\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_article_has_blog_tag".
 *
 * @property integer $blog_article_id
 * @property integer $blog_tag_id
 *
 * @property BlogArticle $blogArticle
 * @property BlogTag $blogTag
 */
class BlogArticleHasBlogTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_article_has_blog_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_article_id', 'blog_tag_id'], 'required'],
            [['blog_article_id', 'blog_tag_id'], 'integer'],
            [['blog_article_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticle::className(), 'targetAttribute' => ['blog_article_id' => 'id']],
            [['blog_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogTag::className(), 'targetAttribute' => ['blog_tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'blog_article_id' => 'Blog Article ID',
            'blog_tag_id' => 'Blog Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticle()
    {
        return $this->hasOne(BlogArticle::className(), ['id' => 'blog_article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTag()
    {
        return $this->hasOne(BlogTag::className(), ['id' => 'blog_tag_id']);
    }
}
