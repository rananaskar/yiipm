<?php

namespace frontend\controllers;

use Yii;
use app\models\Client;
use app\models\User;
use app\models\ClientUsers;
use app\models\Clients;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ClientsController implements the CRUD actions for Client model.
 */
class ClientsController extends AdminController {

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
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Clients;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionCompanies() {
        $searchModel = new Clients;

        $srch_cr = Yii::$app->request->getQueryParams();

        $srch_cr = array_merge($srch_cr, array("client_of_id" => Yii::$app->user->getId()));

        $dataProvider = $searchModel->search($srch_cr);

        return $this->render('companies', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Client;

        $timezone = Yii::$app->db->createCommand("select * from timezone")->queryAll();

        $timezone = ArrayHelper::map($timezone, "id", "name");

        $country = Yii::$app->db->createCommand("select * from country")->queryAll();

        $country = ArrayHelper::map($country, "id", "name");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'timezone' => $timezone,
                        'country' => $country,
                        'model' => $model,
            ]);
        }
    }

    public function actionUsers($client_id) {
        $query = ClientUsers::find();

        $user_id = Yii::$app->user->id;

        $query->sql = "select pcu.* from pm_client_users as pcu inner join pm_users as pu on pu.id=pcu.user_id where pcu.company_id='$client_id'";

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('client_users', [
                    'dataProvider' => $dataProvider,
                    'client_id' => $client_id
        ]);
    }

    public function actionAdduser($client_id) {
        $model = new ClientUsers;

        $model->scenario = "create";

        $timezone = Yii::$app->db->createCommand("select * from timezone")->queryAll();

        $timezone = ArrayHelper::map($timezone, "id", "name");

//        $model->scenario = "create";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            //$model->user_id = $userm->id;
            $model->company_id = $client_id;
            $model->created_on = date("Y-m-d H:i:s");
            $model->created_by_id = Yii::$app->user->getId();
//            $model->scenario = "save";
            $model->save();

            $userm = new User;
            $userm->username = $model->username;
            $userm->password = md5($model->password);
            $userm->email = $model->email;
            $userm->created_on = date("Y-m-d H:i:s");
            $userm->created_by_id = Yii::$app->user->getId();
            $userm->is_admin = 0;
            $userm->save();

            ClientUsers::updateAll(['user_id' => $userm->id], ['id' => $model->id]);

            Yii::$app->session->setFlash("success", "User has been added successfully!!");

            return $this->redirect(['users?client_id=' . $model->company_id]);
        } else {
            return $this->render('adduser', [
                        'timezone' => $timezone,
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdateuser($id) {
        $model = ClientUsers::findOne(['id' => $id]);

        $model->scenario = "update";

        $user = User::findOne(['id' => $model->user_id]);

        $model->username = $user['username'];

        $timezone = Yii::$app->db->createCommand("select * from timezone")->queryAll();

        $timezone = ArrayHelper::map($timezone, "id", "name");

//        $model->scenario = "create";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->updated_on = date("Y-m-d H:i:s");
            $model->updated_by_id = Yii::$app->user->getId();
            $model->save();

            User::updateAll(['username' => $model->username], ['id' => $model->user_id]);

            Yii::$app->session->setFlash("success", "User has been updated successfully!!");

            return $this->redirect(['users?client_id=' . $model->company_id]);
        } else {
            return $this->render('updateuser', [
                        'timezone' => $timezone,
                        'model' => $model,
            ]);
        }
    }

    function actionDeleteuser($id) {
        $client_user=ClientUsers::findOne(['id'=>$id]);
        
        $company_id=$client_user->company_id;
        
        User::deleteAll(['id'=>$client_user->user_id]);
        
        ClientUsers::deleteAll(['id'=>$id]);
        
        Yii::$app->session->setFlash("success", "User has been deleted successfully!!");
        
        return $this->redirect(['users?client_id=' . $company_id]);
        
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $timezone = Yii::$app->db->createCommand("select * from timezone")->queryAll();

        $timezone = ArrayHelper::map($timezone, "id", "name");

        $country = Yii::$app->db->createCommand("select * from country")->queryAll();

        $country = ArrayHelper::map($country, "id", "name");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'timezone' => $timezone,
                        'country' => $country,
                        'model' => $model,
            ]);
        }
    }

    public function actionPermission($client_id) {

//        if(isset($_POST['']))

        if (Yii::$app->request->getIsPost()) {
            Yii::$app->db->createCommand("delete from pm_project_companies where company_id='$client_id'")->execute();
            $i = 0;
            if (isset($_POST['proj'])) {
                foreach ($_POST['proj'] as $k => $prj) {
                    Yii::$app->db->createCommand("insert into pm_project_companies set project_id='$prj',company_id='$client_id'")->execute();
                    $i++;
                }
            }

            Yii::$app->session->setFlash("success", "Company permissions updated successfully. $i records updated");
        }

        $my_projects = array();

        $projects = Yii::$app->db->createCommand("select * from pm_projects")->queryAll();

//        $projects = ArrayHelper::map($projects, "id", "name");

        foreach ($projects as $key => $val) {
            $data = $val;
            $checked = false;

            $dt = Yii::$app->db->createCommand("select * from pm_project_companies where project_id='" . $val['id'] . "' and company_id='$client_id'")->queryOne();

            if (!empty($dt)) {
                $checked = true;
            }

            $data = array_merge($data, array("checked" => $checked));

            $my_projects[] = $data;
        }

        return $this->render('client_permission', [
                    'client_id' => $client_id,
                    'my_projects' => $my_projects,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
