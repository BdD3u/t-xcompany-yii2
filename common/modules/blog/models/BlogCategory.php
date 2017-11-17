<?php

namespace common\modules\blog\models;

//use common\models\User;;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "blog_category".
 *
 * @property integer $id
 * @property string $code
 * @property integer $parent_id
 * @property string $name
 * @property string $description
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $create_at
 * @property string $updated_at
 * @property integer $user_id
 *
 * @property BlogArticle[] $blogArticles
 * @property User $user
 */
class BlogCategory extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            // adding a timestamp to create and update
            'addTimestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['code', 'name', 'create_at', 'updated_at'], 'required'],
            [['code', 'name'], 'required'],
            [['parent_id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['create_at', 'updated_at'], 'safe'],
            [['code', 'name', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
            'code' => 'Code',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'description' => 'Description',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'create_at' => 'Create At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticle::className(), ['blog_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
