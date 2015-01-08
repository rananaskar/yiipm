<?php

namespace app\controllers;

use Yii;
use app\models\Projectusers;
use app\models\ProjectusersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectusersController implements the CRUD actions for Projectusers model.
 */
class ProjectusersController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Projectusers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectusersSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Projectusers model.
     * @param string $project_id
     * @param string $user_id
     * @return mixed
     */
    public function actionView($project_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($project_id, $user_id),
        ]);
    }

    /**
     * Creates a new Projectusers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Projectusers;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Projectusers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $project_id
     * @param string $user_id
     * @return mixed
     */
    public function actionUpdate($project_id, $user_id)
    {
        $model = $this->findModel($project_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Projectusers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $project_id
     * @param string $user_id
     * @return mixed
     */
    public function actionDelete($project_id, $user_id)
    {
        $this->findModel($project_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Projectusers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $project_id
     * @param string $user_id
     * @return Projectusers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($project_id, $user_id)
    {
        if (($model = Projectusers::findOne(['project_id' => $project_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
