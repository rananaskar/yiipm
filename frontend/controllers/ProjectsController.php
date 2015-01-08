<?php

namespace frontend\controllers;

use Yii;
use app\models\Project;
use app\models\Projects;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * ProjectsController implements the CRUD actions for Project model.
 */
class ProjectsController extends AdminController {

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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex() {
        if ($this->isAdmin == 1) {
            $searchModel = new Projects;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        } else {

            $query = Project::find();

            if ($this->userType == 0) {

                $user_id = Yii::$app->user->id;

                $query->sql = "SELECT proj.* FROM pm_projects AS proj LEFT JOIN pm_project_companies AS pcom ON pcom.project_id = proj.id
LEFT JOIN pm_companies AS com ON pcom.company_id = com.id LEFT JOIN pm_client_users AS usr ON usr.company_id = com.id WHERE usr.user_id ='$user_id'";
            } else if ($this->userType == 2) {
                $user_id = Yii::$app->user->id;
                $query->sql = "SELECT proj.* FROM pm_projects AS proj LEFT JOIN pm_project_users AS pu ON pu.project_id = proj.id WHERE pu.user_id ='$user_id'";
            }

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        }

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
//                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view_project', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionMessages($project_id) {

        $data = Yii::$app->db->createCommand("select pm.*,pu.is_admin from pm_project_messages pm inner join pm_users pu on pu.id=pm.created_by_id where pm.project_id='$project_id'")->queryAll();

        $messages = array();

        foreach ($data as $k => $msg) {

            $user_name = "Admin";

            if ($msg['is_admin'] == 0) {
                $client_data = \app\models\ClientUsers::findOne(['user_id' => $msg['created_by_id']]);
                $user_name = $client_data->first_name . " " . $client_data->last_name;
            } else if ($msg['is_admin'] == 2) {
                $client_data = \app\models\Companyusers::findOne(['user_id' => $msg['created_by_id']]);
                $user_name = $client_data->first_name . " " . $client_data->last_name;
            }

            $msg['full_name'] = $user_name;

            

            $datas = array(
                "message_data" => $msg
            );

            $messages[] = $datas;
        }

        return $this->render('messages', [
                    'model' => $this->findModel($project_id),
                    'messages' => $messages
        ]);
    }

    public function actionViewmessage($message_id) {

        $message_data = Yii::$app->db->createCommand("select pm.*,pu.is_admin from pm_project_messages pm inner join pm_users pu on pu.id=pm.created_by_id where pm.id='$message_id'")->queryOne();

        if (Yii::$app->request->getIsPost()) {
            $request = Yii::$app->request->post();
            $comment = $request['comment'];
            $comment_model = new \app\models\Comment();
            $comment_model->rel_object_id = $message_id;
            $comment_model->rel_object_manager = "ProjectMessage";
            $comment_model->text = $comment;
            $comment_model->is_private = $message_data['is_private'];
            $comment_model->created_on = date("Y-m-d H:i:s");
            $comment_model->created_by_id = Yii::$app->user->id;
            $comment_model->updated_on = date("Y-m-d H:i:s");
            $comment_model->updated_by_id = Yii::$app->user->id;
            $comment_model->save();
            Yii::$app->session->setFlash("success", "Comment posted successfully");
        }


        $user_name = "Admin";

        if ($message_data['is_admin'] == 0) {
            $client_data = \app\models\ClientUsers::findOne(['user_id' => $message_data['created_by_id']]);
            $user_name = $client_data->first_name . " " . $client_data->last_name;
        } else if ($message_data['is_admin'] == 2) {
            $client_data = \app\models\Companyusers::findOne(['user_id' => $message_data['created_by_id']]);
            $user_name = $client_data->first_name . " " . $client_data->last_name;
        }

        $message_data['full_name'] = $user_name;

        $project_data = Project::findOne(['id' => $message_data['project_id']]);

        $comments = array();

        $dtcom = Yii::$app->db->createCommand("SELECT pm_users.is_admin,pm_comments.* FROM `pm_comments` inner join `pm_users` ON pm_users.id=pm_comments.created_by_id where pm_comments.rel_object_id='$message_id'")->queryAll();

        foreach ($dtcom as $k => $comm) {


            $user_name = "Admin";

            if ($comm['is_admin'] == 0) {
                $client_data = \app\models\ClientUsers::findOne(['user_id' => $comm['created_by_id']]);
                $user_name = $client_data->first_name . " " . $client_data->last_name;
            } else if ($comm['is_admin'] == 2) {
                $client_data = \app\models\ClientUsers::findOne(['user_id' => $comm['created_by_id']]);
                $user_name = $client_data->first_name . " " . $client_data->last_name;
            }

            $comm['full_name'] = $user_name;

            $cmdata = array('comment_data' => $comm);

            $comments[] = $cmdata;
        }

        return $this->render('view_message', [
                    'message_data' => $message_data,
                    'comments' => $comments,
                    'project_data' => $project_data
        ]);
    }

    public function actionNewmessage($project_id) {

        if (Yii::$app->request->getIsPost()) {

            $request = Yii::$app->request->post();

            $title = $request['title'];
            $txtmessage = $request['message'];

            $private = 0;

            if (isset($request['post_private'])) {
                $private = 1;
            }

            $message = new \app\models\ProjectMessage();

            $message->project_id = $project_id;
            $message->is_private = $private;
            $message->title = $title;
            $message->text = $txtmessage;
            $message->created_on = date("Y-m-d H:i:s");
            $message->created_by_id = Yii::$app->user->id;

            if ($message->save()) {

                foreach ($request['users'] as $ind => $usr) {
                    Yii::$app->db->createCommand("insert into pm_message_subscriptions set user_id='" . $usr . "',message_id='" . $message->id . "'")->execute();
                }

                Yii::$app->session->setFlash("success", "Message posted successfully!!");
                return $this->redirect(["view?id=" . $project_id]);
            }
        }

        $clients = array();

        $project_client = Yii::$app->db->createCommand("select com.* from pm_companies com inner join pm_project_companies pcom on pcom.company_id=com.id where pcom.project_id='$project_id'")->queryAll();

        foreach ($project_client as $key => $val) {
            $client_users = Yii::$app->db->createCommand("select * from pm_client_users where company_id='" . $val['id'] . "'")->queryAll();
            $clients[] = array("client_data" => $val, "user_data" => $client_users);
        }

        return $this->render('newmessage', [
                    'model' => $this->findModel($project_id),
                    'clients' => $clients
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Project;

        $projects = Yii::$app->db->createCommand("select * from pm_projects")->queryAll();

        $projects = ArrayHelper::map($projects, "id", "name");

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->parent_id = $_POST['Project']['parent_id'];

            $model->created_by_id = Yii::$app->user->getId();

            $model->created_on = date("Y-m-d H:i:s");

            $model->save();

            Yii::$app->db->createCommand("insert into pm_project_users set project_id='" . $model->id . "',user_id='" . Yii::$app->user->getId() . "',created_on='" . date("Y-m-d H:i:s") . "',created_by_id='" . Yii::$app->user->getId() . "'")->execute();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'projects' => $projects,
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $projects = Yii::$app->db->createCommand("select * from pm_projects where id!='$id'")->queryAll();

        $projects = ArrayHelper::map($projects, "id", "name");

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->updated_by_id = Yii::$app->user->getId();

            $model->parent_id = $_POST['Project']['parent_id'];

            $model->updated_on = date("Y-m-d H:i:s");

            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'projects' => $projects,
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
