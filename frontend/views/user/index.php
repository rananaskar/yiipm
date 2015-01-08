<style>
    .glyphicon-eye-open{
        /*display: none;*/
    }
</style>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\Users $searchModel
 */
$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create New User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'fullname:text:Name',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'gender',
                'label' => "Gender",
                'value' => function($model) {
            return ucfirst($model->gender);
        }
            ],
            'email:email',
            'username',
//            'password',
            // 'joined_date',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'dob',
                'label' => "Date of Birth",
                'value' => function($model) {
            return date("d-m-Y", strtotime($model->dob));
        }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
