<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var frontend\models\CompanyusersSearch $searchModel
 */
$this->title = 'Companyusers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companyusers-index">

    <h1>User List</h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create new user', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            // 'company_id',
            ['class' => 'yii\grid\DataColumn',
                'label' => 'User Name',
                'format' => 'html',
                'value' => function ($data) {
                    $user = new app\models\User;
                    $userName=$user->findAll(['id'=>$data->user_id]);
                    $userName= count($userName)==0 ? "" : $userName['0']['username'] ;
                    return $userName;
                },
            ],
         //   'user_id',
            'email:email',
            'display_name',
            // 'first_name',
            // 'middle_name',
            // 'last_name',
            // 'title',
            // 'avatar_file',
            // 'use_gravatar',
            // 'is_favorite',
            // 'timezone:datetime',
            // 'office_number',
            // 'fax_number',
            // 'mobile_number',
            // 'home_number',
            // 'license_plate',
            // 'food_preferences',
            // 'department_details',
            // 'location_details',
            // 'language_preferences',
            // 'created_on',
            // 'created_by_id',
            // 'updated_on',
            // 'updated_by_id',
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\DataColumn',
                'label' => 'Status',
                'format' => 'html',
                'value' => function ($data) {
                    $user = new app\models\User;
                    $userModel=$user->findAll(['id'=>$data->user_id]);
                    $statusList=\Yii::$app->params['statusList'];
                    $status=$userModel['0']['status'];
                     
                    return isset($statusList[$status]) ? $statusList[$status] : "";
                },
            ],
            ['class' => 'yii\grid\DataColumn',
                'label' => '',
                'format' => 'html',
                'value' => function ($data) {
                    $link=Yii::$app->urlManager->createUrl("companyusers/editpermissions?id=".$data->id);
                    return '<a href="'.$link.'">Edit Permission </a>';
                },
            ],
        ],
    ]);
    ?>

</div>
