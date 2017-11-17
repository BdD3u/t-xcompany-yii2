<?php

namespace backend\controllers;

use backend\models\UserForm;
use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->view->title = 'Пользователи';
        $this->view->params['breadcrumbs'] = [
            $this->view->title,
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $userForm = new UserForm(
            new User,
            \Yii::$app->getAuthManager()
        );

        $this->view->title = 'Новый пользователь';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Пользователи', 'url' => ['index']],
            $this->view->title
        ];

        return $this->editUser($userForm);;
    }

    protected function editUser(UserForm $userForm)
    {
        $created = false;
        $request = Yii::$app->getRequest();

        try {
            if ($request->isPost && $userForm->load($request->post())) {
                $created = $userForm->save();
            }
        } catch (\Throwable $exception) {
            Yii::$app->session->setFlash('error', nl2br(
                $exception->getMessage()
                . PHP_EOL
                . $exception->getTraceAsString()
            ));
        }

        if ($created) {
            Yii::$app->session->setFlash('success', 'Создан новый пользователь (ID: '
                . $userForm->getUser()->id . ')');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $userForm,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $userForm = new UserForm(
            $model,
            \Yii::$app->getAuthManager()
        );

        $this->view->title = 'Редактирование пользователя ' . $model->username;
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Пользователи', 'url' => ['index']],
            //['label' => $this->view->title],
            $this->view->title
        ];

        return $this->editUser($userForm);


//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Пользователь (ID: ' . $id . ') удален.');
        } else  {
            Yii::$app->session->setFlash('error', 'Не удалось удалить пользователя (ID: ' . $id . ') удален.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
