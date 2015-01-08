<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\ProjectusersSearch $searchModel
 */

$this->title = 'Projectusers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projectusers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Projectusers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'project_id',
            'user_id',
            'note:ntext',
            'role_id',
            'created_on',
            // 'created_by_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
