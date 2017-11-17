<?php

namespace common\modules\blog\controllers;

use common\modules\blog\models\BlogArticleAdminForm;
//use common\modules\blog\wblocks\CategoryMenu\Block;
use Yii;
use common\modules\blog\models\BlogArticle;
use common\modules\blog\models\BlogArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogArticleController implements the CRUD actions for BlogArticle model.
 */
class BlogArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCopy($id)
    {
        $article = BlogArticle::find()->where('id=:id', ['id' => $id])->asArray()->limit(1)->one();

        if(!$article) {
            throw new NotFoundHttpException('Новость, которую вы хотели скопировать, не найдена.');
        }
        unset($article['id']);
        $article['code'] .= uniqid();
        $fBlogArticle =new BlogArticleAdminForm(new BlogArticle($article));
        $copyOk = $this->saveArticleForm($fBlogArticle);

        if ($copyOk) {
            Yii::$app->session->setFlash('success', 'Создана новая статья ID:' . $fBlogArticle->getArticle()->id . '.');
            return $this->redirect(['index']);
        }

        $this->view->title = 'Новая статья';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Блог', 'url' => ['/admin/blog']],
            ['label' => 'Статьи', 'url' => ['index']],
            $this->view->title,
        ];

        return $this->render('create', compact('fBlogArticle'));
    }

    /**
     * Lists all BlogArticle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->view->title = 'Статьи';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Блог', 'url' => ['/admin/blog']],
            $this->view->title,
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Helper for saving data of form BlogArticleAdminForm.
     *
     * @param BlogArticleAdminForm $form
     * @return bool
     */
    protected function saveArticleForm(BlogArticleAdminForm $form): bool
    {
        $saved = false;
        try {
            $saved = Yii::$app->request->isPost
                && $form->load(Yii::$app->request->post())
                && $form->save();
        } catch (\Throwable $exception) {

            $errorMess = nl2br(
                $exception->getMessage() . PHP_EOL .
                $exception->getTraceAsString()
            );
            //var_dump($fBlogArticle->getErrors());
            Yii::$app->session->setFlash('error', $errorMess);
        }

        return $saved;
    }

    /**
     * Creates a new BlogArticle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $fBlogArticle = new BlogArticleAdminForm(new BlogArticle());
        $created = $this->saveArticleForm($fBlogArticle);

        if ($created) {
            Yii::$app->session->setFlash('success', 'Создана новая статья ID:' . $fBlogArticle->getArticle()->id . '.');
            return $this->redirect(['index']);
        }

        $this->view->title = 'Новая статья';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Блог', 'url' => ['/admin/blog']],
            ['label' => 'Статьи', 'url' => ['index']],
            $this->view->title,
        ];

        return $this->render('create', compact('fBlogArticle'));
    }

    /**
     * Updates an existing BlogArticle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $article = BlogArticle::find()->where('id=:id', ['id' => $id])->with('image')->limit(1)->one();

        if (!$article) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $fBlogArticle = new BlogArticleAdminForm($article);
        $updated = $this->saveArticleForm($fBlogArticle);
//        $updated = false;
//
//        try {
//            $updated = Yii::$app->request->isPost
//                && $fBlogArticle->load(Yii::$app->request->post())
//                && $fBlogArticle->save();
//        } catch (\Throwable $exception) {
//            Yii::$app->session->setFlash('error', $exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
//        }

        if ($updated) {
            Yii::$app->session->setFlash('success', 'Успешное обновление статьи ID:' . $id . '.');
            return $this->redirect(['index']);
        }

        $this->view->title = $fBlogArticle->getArticle()->title;
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Блог', 'url' => ['/admin/blog']],
            ['label' => 'Статьи', 'url' => ['index']],
            $this->view->title,
        ];

        return $this->render('create', compact('fBlogArticle'));
    }

    /**
     * Deletes an existing BlogArticle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Удалена статья ID:' . $id . '.');
        } else {
            Yii::$app->session->setFlash('error', 'При удалении статьи id:' . $id . ' возникла проблема... Возможно что статья не удалилась.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the BlogArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogArticle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogArticle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
