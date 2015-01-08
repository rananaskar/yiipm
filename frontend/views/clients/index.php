<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\Clients $searchModel
 */
$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Add Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\DataColumn',
                'format' => 'html',
                'label' => "Options",
                'value' => function($model) {
                    $str = "
                        <a href='".Yii::$app->urlManager->createUrl(array("clients/users?client_id=".$model->id))."'>User List</a>
                        |
                        <a href='".Yii::$app->urlManager->createUrl(array("clients/permission?client_id=".$model->id))."'>Permissions</a>
                        |
                        <a href='".Yii::$app->urlManager->createUrl(array("clients/update?id=".$model->id))."'>Edit</a>
                        |";
                    
                    $str.='
                        <a href="'.Yii::$app->urlManager->createUrl(array("clients/delete?id=".$model->id)).'" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                        Delete
                        </a>
                        ';
                    
                    return $str;
                }
            ],
//            'description:ntext',
//            'email:email',
            // 'address',
            // 'city',
            // 'state',
            // 'zipcode',
            // 'country',
//            'phone_number',
            // 'logo_file',
            // 'timezone',
            // 'created_on',
            // 'created_by_id',
            // 'updated_on',
            // 'updated_by_id',
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
