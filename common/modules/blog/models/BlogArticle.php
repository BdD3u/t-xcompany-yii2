<?php

namespace common\modules\blog\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

//use common\models\User;

/**
 * This is the model class for table "blog_article".
 *
 * @property integer $id
 * @property string $code
 * @property integer $active
 * @property string $title
 * @property string $preview_content
 * @property string $content
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $image_id
 * @property integer $blog_category_id
 * @property integer $user_id
 *
 * @property BlogCategory $blogCategory
 * @property BlogImage $image
 * @property User $user
 * @property BlogArticleHasBlogTag[] $blogArticleHasBlogTags
 * @property BlogTag[] $blogTags
 */
class BlogArticle extends \yii\db\ActiveRecord
{
    protected $wasImageIdBeforeUpdating;

    public function behaviors()
    {
        return [
            // adding a timestamp to create and update
            'addTimestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function init()
    {
        // save image_id before updating.
        $this->on(static::EVENT_BEFORE_UPDATE, function($event) {
           /** @var BlogArticle $sender */
           $sender = $event->sender;
           $sender->wasImageIdBeforeUpdating = $sender->getOldAttribute('image_id');
        });

        // if image changed -> remove old
        $this->on(static::EVENT_AFTER_UPDATE, function($event){
           /** @var BlogArticle $sender*/
           $sender = $event->sender;
           if($sender->wasImageIdBeforeUpdating && $sender->wasImageIdBeforeUpdating !== $sender->image_id
                && ($oldImage =BlogImage::find()->where('id=:id', ['id' => $this->wasImageIdBeforeUpdating])->one())) {
               $oldImage->delete();
           }
        });

        // if article deleted -> remove image...
        $this->on(static::EVENT_AFTER_DELETE, function($event) {
           if($this->image_id && ($img =BlogImage::findOne($this->image_id))) {
               $img->delete();
           }
        });
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'active', 'title', 'blog_category_id', 'user_id'], 'required'],
            [['active', 'image_id', 'blog_category_id', 'user_id'], 'integer'],
            [['preview_content', 'content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'title', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['blog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['blog_category_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' =>BlogImage::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'active' => 'Активный',
            'title' => 'Заголовок',
            'preview_content' => 'Превью контент',
            'content' => 'Контент',
            'seo_keywords' => 'Seo: ключевые слова',
            'seo_description' => 'Seo: описание',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'image_id' => 'Главное изображение',
            'blog_category_id' => 'Категория',
            'user_id' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'blog_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(BlogImage::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticleHasBlogTags()
    {
        return $this->hasMany(BlogArticleHasBlogTag::className(), ['blog_article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTag::className(), ['id' => 'blog_tag_id'])->viaTable('blog_article_has_blog_tag', ['blog_article_id' => 'id']);
    }
}
