<?php

namespace common\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_tag".
 *
 * @property integer $id
 * @property string $name
 *
 * @property BlogArticleHasBlogTag[] $blogArticleHasBlogTags
 * @property BlogArticle[] $blogArticles
 */
class BlogTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticleHasBlogTags()
    {
        return $this->hasMany(BlogArticleHasBlogTag::className(), ['blog_tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticle::className(), ['id' => 'blog_article_id'])->viaTable('blog_article_has_blog_tag', ['blog_tag_id' => 'id']);
    }

    /**
     * Return list for dropdown menu.
     * @return array
     */
    public static function getListDropDown()
    {
        $tags = static::find()->limit(1000)->orderBy('name')->asArray()->all();
        return array_column($tags, 'name', 'id');
    }
}
