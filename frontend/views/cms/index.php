<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\ $searchModel
 */
$this->title = 'CMS Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .glyphicon-trash{
        display: none;
    }
</style>
<div class="cms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

<!--    <p>
        <?= Html::a('Create CMS Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'pagename:text:Page Name',
            'title:text:Title',
//            'pagedetails:ntext:Content',
//            'status',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'status',
                'format' => 'text',
                'label' => 'Status',
                'value' => function ($model) {
            $status = "";
            if ($model->status == "1") {
                $status = "Active";
            } else {
                $status = "Inactive";
            }
            return $status;
        },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
