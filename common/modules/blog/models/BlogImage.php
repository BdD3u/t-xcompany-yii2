<?php

namespace common\modules\blog\models;

//use common\models\User;
use common\modules\blog\Module as BlogModule;
use Yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $title
 * @property string $origin_name
 * @property string $name
 *
 * @property User[] $users
 */
class BlogImage extends \yii\db\ActiveRecord
{
    //const UPLOAD_DIR = '';
    protected $nameBeforeUpdating;
    protected $realPath;
    protected $webPath;
    
    public static function getUploadDir(): string
    {
        return BlogModule::getInstance()->uploadPath;
    }

    public static function getUploadDirUrl(): string
    {
        return BlogModule::getInstance()->uploadWebPath;
    }

    public function init()
    {


        // remove file after delete
        $this->on(static::EVENT_AFTER_DELETE, function ($event) {
            if (is_file($this->getRealPath())) {
                unlink($this->getRealPath());
            }
        });
        // safe old name
        $this->on(static::EVENT_BEFORE_UPDATE, function ($event) {
            $this->nameBeforeUpdating = $this->name;
        });
        // remove old file
        $this->on(static::EVENT_AFTER_UPDATE, function ($event) {
            $oldFile = static::getUploadDir() . '/' . $this->nameBeforeUpdating;
            if ($this->nameBeforeUpdating && $this->nameBeforeUpdating !== $this->name && is_file($oldFile)) {
                unlink($oldFile);
            }
        });
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_image}}';
    }

    /**
     * @return string
     */
    public function getWebPath(): string
    {

        if(null !== $this->webPath) {
            return $this->webPath;
        }

        if (is_file($this->getRealPath())) {
            $this->webPath = static::getUploadDirUrl() . '/' . $this->name;
        } elseif (is_file(static::getUploadDir()  . '/' .  'noimage.png')) {
            $this->webPath = static::getUploadDirUrl() . '/' . 'noimage.png';
        } else {
            $this->webPath = '';
        }
//        var_dump($this->webPath);
//        die('test');
        return $this->webPath;
    }

    public function getRealPath(): string
    {
        if(!$this->realPath) {
            $this->realPath = static::getUploadDir()  . '/' . $this->name;
        }
        return $this->realPath;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['origin_name', 'name'], 'required'],
            [['title', 'origin_name'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 36],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'origin_name' => 'Наименование исходника',
            'name' => 'Имя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['image_id' => 'id']);
    }
}
