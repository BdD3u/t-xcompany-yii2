<?php
namespace common\modules\blog\models;


use Yii;
use common\modules\blog\wblocks\CategoryMenu\Block as BlockCategoryList;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class BlogArticleAdminForm extends Model
{
    /** @var  array $listCategories */
    protected $listCategories;
    /** @var BlogArticle  */
    protected $obBlogArticle;
    protected $imageUploader;
    protected $listTags;
    public $selectedTags;

    public function __construct(BlogArticle $obBlogArticle, array $config = [])
    {
        $this->obBlogArticle = $obBlogArticle;
        $this->listCategories = BlockCategoryList::incl('items-dropdown.php');
        $this->imageUploader = new ImageUploader();
        $this->listTags = BlogTag::getListDropDown();


        $obBlogArticle->user_id = Yii::$app->user->getId();;

        if($obBlogArticle->isNewRecord) {
            $obBlogArticle->active = 1;
            $this->selectedTags = [];
        } else {
            //$this->selectedTags = ArrayHelper::getColumn($obBlogArticle->blogTags, 'id');
            //var_dump($obBlogArticle->blogArticleHasBlogTags);
            $this->selectedTags = array_column($obBlogArticle->blogArticleHasBlogTags, 'blog_tag_id');
        }

        parent::__construct($config);
    }

    public function getImageUploader(): ImageUploader
    {
        return $this->imageUploader;
    }

    public function getArticle(): BlogArticle
    {
        return $this->obBlogArticle;
    }

    public function getListCategories(): array
    {
        return $this->listCategories;
    }

    public function getListTags(): array
    {
        return $this->listTags;
    }


    public function attributeLabels()
    {
        return [
          'selectedTags' => 'Теги',
          'mainImage' => 'Изображение',
        ];
    }

    public function rules()
    {
        return [
            ['selectedTags', 'each', 'rule' => ['in', 'range' => array_keys($this->listTags)], 'message' => 'Выбраны несуществующие теги...'],
        ];
    }

    public function save()
    {
        $complete = false;
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $uploaded = $this->imageUploader->upload();
            $imageId = isset($uploaded[0]) ? $uploaded[0]->id : null;

            if(!$this->imageUploader->hasErrors()) {
                $this->obBlogArticle->image_id = $imageId ? $imageId : $this->obBlogArticle->image_id;
                $complete = $this->obBlogArticle->save() && $this->rewriteTags();
            }

            if(!$complete) {
                throw new \Exception('Could not save. Check the required fields.');
            }

            $transaction->commit();
        } catch(\Throwable $exception) {
            $transaction->rollBack();
            $this->addErrors($this->imageUploader->getErrors());
            $this->addErrors($this->obBlogArticle->getErrors());
            throw $exception;
        }

        return $complete;
    }

    public function rewriteTags()
    {
        $complete = true;
        // Deleting old tags. Note events will not be executed.
        if($articleId = (int) $this->obBlogArticle->id) {
            BlogArticleHasBlogTag::deleteAll(['blog_article_id' => $articleId]);
        } else {
            $complete = false;
        }
        if(is_array($this->selectedTags) && $articleId) {
            foreach($this->selectedTags as $tagId) {
                $tag = new BlogArticleHasBlogTag(['blog_article_id' => $this->obBlogArticle->id, 'blog_tag_id' => $tagId]);
                if(!$tag->save()) {
                    $complete = false;
                    foreach($tag->errors as $error) {
                        $this->addError('selectedTags', implode(PHP_EOL, $error));
                    }
                    break;
                }
            }
        }
        return $complete;
    }

    public function load($data, $formName = null)
    {

        $this->imageUploader->imageFiles = UploadedFile::getInstances($this->imageUploader, 'imageFiles');

        $vImage = $this->imageUploader->validate();
        $vArticle = $this->obBlogArticle->load($data, $formName);
        $thisForm = parent::load($data, $formName);

        return $vImage && $vArticle && $thisForm;
    }
}