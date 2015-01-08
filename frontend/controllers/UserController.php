<?php

namespace frontend\controllers;

use Yii;
use app\models\User;
use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AdminController {

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Users;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        $consumption_detail = array();

//        $dates = Yii::$app->db->createCommand("select distinct(date_consume) as cdate from sugar_food_intake where userid='$id'")->queryAll();
        $dates = Yii::$app->db->createCommand("select date_consume,sum(calorie_consume) as t_calorie,sum(sugar_consume) as t_sugar,sum(fat_consume) as t_fat,sum(protein_consume) as t_protein from sugar_food_intake where userid='$id' and date_consume=(select distinct(date_consume) as cdate from sugar_food_intake where userid='$id')")->queryAll();

        foreach ($dates as $key => $val) {
            $data = array();

            $t_calorie = $val['t_calorie'];
            $t_fat = $val['t_fat'];
            $t_protein = $val['t_protein'];
            $t_sugar = $val['t_sugar'];

            $foods = "";

            $condata = Yii::$app->db->createCommand("select distinct(foodname) from sugar_food_intake where userid='$id' and date_consume='" . $val['date_consume'] . "'")->queryAll();

            foreach ($condata as $k => $v) {
                if ($k == 0) {
                    $foods = $v['foodname'];
                } else {
                    $foods.="," . $v['foodname'];
                }
            }

            $data['date'] = date("d-m-Y", strtotime($val['date_consume']));
            $data['t_cal'] = number_format($t_calorie, 2);
            $data['t_fat'] = number_format($t_fat, 2);
            $data['t_protein'] = number_format($t_protein, 2);
            $data['t_sugar'] = number_format($t_sugar, 2);
            $data['foods'] = $foods;
            if ($val['date_consume'] != "") {
                $consumption_detail[] = $data;
            }
        }

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    "consumption_detail" => $consumption_detail
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User(['scenario' => 'create']);
        $model->joined_date = date("Y-m-d");
        $model->user_type = "U";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $req = Yii::$app->request->post('User');
            $model->password = md5($req['password']);
            $model->save();
            Yii::$app->session->setFlash("success", "User Updated Successfully!!");
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $old_password = $model->password;

        $model->password = "";

        if (Yii::$app->request->post() == true) {

            $req = Yii::$app->request->post('User');
            if ($req['password'] != "") {
                $model->password = md5($req['password']);
            } else {
                $model->password = $old_password;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($req['password'] != "") {
                $model->password = md5($req['password']);
            } else {
                $model->password = $old_password;
            }

            $model->save();
            Yii::$app->session->setFlash("success", "User Updated Successfully!!");
            return $this->redirect(['index']);
        } else {
//            echo "<pre>";
//            print_r($model->getErrors());
//            echo "</pre>";
//            exit;
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash("success", "User Deleted Successfully!!");
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
