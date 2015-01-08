<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\Clients $searchModel
 */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
//            'description:ntext',
            'email:email',
            // 'address',
            // 'city',
            // 'state',
            // 'zipcode',
            // 'country',
             'phone_number',
            // 'logo_file',
            // 'timezone',
            // 'created_on',
            // 'created_by_id',
            // 'updated_on',
            // 'updated_by_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
