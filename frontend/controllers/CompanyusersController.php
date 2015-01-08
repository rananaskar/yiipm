<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Companyusers;
use app\models\User;
use frontend\models\CompanyusersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CompanyusersController implements the CRUD actions for Companyusers model.
 */
class CompanyusersController extends Controller {

    public function behaviors() {
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
     * Lists all Companyusers models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CompanyusersSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Companyusers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Companyusers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Companyusers;
        $model->scenario = 'create';
        $timezone = Yii::$app->db->createCommand("select * from timezone")->queryAll();

        $timezone = ArrayHelper::map($timezone, "id", "name");
        //$statusList=["1"=>"Active","0"=>"In-active"];
        $statusList=\Yii::$app->params['statusList'];
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                $id = $model->id;
                $user = new User;
                $user->username = $model->user_name;
                $user->password = md5($model->password);
                $user->email = $model->email;
                $user->status = $model->status;
                $user->is_admin = 2;
                if ($user->save()) {
                    $user_id = $user->id;
                    $up_model = $this->findModel($id);
                    //$up_model->user_id = $user_id;
                    $up_model->updateAll(["user_id" => $user_id], ["id" => $id]);
                }
            } else {
                print_r($model->getError());
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'timezone' => $timezone,
                        'status' => $statusList,
            ]);
        }
    }

    /**
     * Updates an existing Companyusers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        //$model = new Companyusers;
        $timezone = Yii::$app->db->createCommand("select * from timezone")->queryAll();

        $timezone = ArrayHelper::map($timezone, "id", "name");
        $m = $this->findModel($id);
        $statusList=["1"=>"Active","0"=>"In-active"];
        $user = new User;
        $userModel = $user::findOne($m->user_id);
        // var_dump($userModel);
        $model->user_name = $userModel->username;
       $model->status = $userModel->status; 
        $model->password = "";
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $userModel->username = $model->user_name;
                if($model->password!=""){
                   $userModel->password = md5($model->password); 
                }
                $userModel->email = $model->email;
                $userModel->status = $model->status;
                $userModel->save();
            }
            return $this->redirect(['index']);
        } else {
            
            return $this->render('update', [
                        'model' => $model,
                        'timezone' => $timezone,
                        'id' => $id,
                        'status'=>$statusList
            ]);
        }
    }

    /**
     * Deletes an existing Companyusers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        $m = $this->findModel($id);
        //echo $m->user_id;
        $this->findModel($id)->delete();
        $user = new User;
        $userModel = $user::findOne($m->user_id);
        if ($userModel)
            $userModel->delete();
        // echo "<br>".$user->findAll(['id'=>$m->user_id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Companyusers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Companyusers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Companyusers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEditpermissions($id) {
        $userModel = $this->findModel($id);
        $user_id = $userModel->user_id;
        $searchModel = new \app\models\Projects;
        $projects = Yii::$app->db->createCommand("select * from pm_projects")->queryAll();
        $projectuserModel = new \app\models\Projectusers;
        $projects = ArrayHelper::map($projects, "id", "name");
        $assigned = $projectuserModel->findAll(["user_id" => $user_id]);
        $assigned_arr = ArrayHelper::map($assigned, "project_id", "user_id");
        if (isset($_POST["companyusers"])) {
            if (count($assigned) > 0) {
                Yii::$app->db->createCommand("DELETE FROM pm_project_users WHERE user_id='$user_id' ")->execute();
            }
            if (isset($_POST["companyusers"]["selected"])) {
                foreach ($_POST["companyusers"]["selected"] as $pId) {

                    Yii::$app->db->createCommand("insert into pm_project_users set project_id='$pId',user_id='$user_id'")->execute();
                }
            }
            return $this->redirect(['index']);
        }
        return $this->render('permission', [
                    'userModel' => $userModel,
                    'projects' => $projects,
                    'assigned_arr'=>$assigned_arr
                    
        ]);
    }

}
