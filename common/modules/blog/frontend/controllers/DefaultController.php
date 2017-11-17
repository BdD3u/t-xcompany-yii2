<?php
namespace common\modules\blog\frontend\controllers;

use common\modules\blog\frontend\assets\MainAsset;
use common\modules\blog\models\BlogArticle;
use common\modules\blog\models\BlogCategory;
use common\modules\blog\Module;
use common\modules\blog\wblocks\CategoryMenu\Block;
use yii\data\Pagination;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function init()
    {
        MainAsset::register($this->view);
    }

    public function actionIndex()
    {
       $blogMap = Block::incl('nav-items.php');
       return $this->render('sections', compact('blogMap'));
    }

    public function actionSection($id)
    {
        if(!($id = (int)$id) || !($category = BlogCategory::findOne($id))) {
            throw  new NotFoundHttpException('Нет такой категории.');
        }

        $qArticle = BlogArticle::find()
            ->select(['id', 'code', 'title', 'preview_content', 'image_id'])
            ->where('blog_category_id=:id', [':id' => $id]);

        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $qArticle->count(),
        ]);

        $articles = $qArticle->orderBy('created_at')
            ->with('image')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $this->view->title = $category->name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['/blog']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('section', compact('pagination', 'articles', 'cat'));
    }

    public function actionArticle($id)
    {
        if(!($id = (int) $id)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        $article =BlogArticle::find()
            ->where('id=:id', [':id' => $id])
            ->limit(1)
            ->one();

        if(!$article) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        $this->view->title = $article->title;
        $this->view->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['/blog']];
        $this->view->params['breadcrumbs'][] = StringHelper::truncate(strip_tags($this->view->title), 25, '...');

        return $this->render('article', compact('article'));
    }
}