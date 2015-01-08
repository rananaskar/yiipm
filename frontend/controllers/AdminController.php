<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\components\FrontController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Controller is the base class of web controllers.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminController extends Controller {

    public $isAdmin = false;
    public $userType = 0;

    function beforeAction($action) {

        $allowed = array("actionLogin");

        if (!in_array($action->controller->action->actionMethod, $allowed)) {
            if (Yii::$app->user->isGuest) {
                return $this->redirect(['site/login']);
            } else {
                if (Yii::$app->session->has('isAdmin') == false) {
                    $user_data = \app\models\Users::findOne(["id" => Yii::$app->user->id]);

                    Yii::$app->session->set("isAdmin", $user_data->is_admin == 1 ? 1 : 0 );
                    Yii::$app->session->set("userType", $user_data->is_admin);
                }

                $this->isAdmin = Yii::$app->session->get('isAdmin');
                $this->userType = Yii::$app->session->get("userType");
            }
        }

        return true;
    }

}
