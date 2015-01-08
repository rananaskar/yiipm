<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\Projects $searchModel
 */
$this->title = 'My Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php
        if (Yii::$app->session->get("isAdmin")):
            ?>
            <?= Html::a('Add Project', ['create'], ['class' => 'btn btn-success']) ?>
            <?php
        endif;
        ?>
    </p>
    <?php
    if (Yii::$app->session->get("isAdmin")) {
        ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
//            [
//                'class' => 'yii\grid\DataColumn',
//                'format' => 'ntext',
//                'label' => "Parent Project",
//                'contentOptions' => ['style' => 'width:100px; height:100px;'],
//                'value' => function($model) {
//                    $project_name = "None";
//                    if($model->parent_id!=0){
//                        $data=  app\models\Project::findOne(['id'=>$model->parent_id]);
//                        $project_name=$data->name;
//                    }
//                    return $project_name;
//                }
//            ],
                // 'logo_file',
                // 'completed_on',
                // 'completed_by_id',
                // 'created_on',
                // 'created_by_id',
                // 'updated_on',
                // 'updated_by_id',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
        <?php
    } else {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//                'name',
                [
                    'class' => 'yii\grid\DataColumn',
                    'format' => 'html',
                    'label' => "Project",
                    'value' => function($model) {
                        return '<a href="'.Yii::$app->urlManager->createUrl('projects/view?id='.$model->id).'">'.$model->name.'</a>';
                    }
                ],
//            [
//                'class' => 'yii\grid\DataColumn',
//                'format' => 'ntext',
//                'label' => "Parent Project",
//                'contentOptions' => ['style' => 'width:100px; height:100px;'],
//                'value' => function($model) {
//                    $project_name = "None";
//                    if($model->parent_id!=0){
//                        $data=  app\models\Project::findOne(['id'=>$model->parent_id]);
//                        $project_name=$data->name;
//                    }
//                    return $project_name;
//                }
//            ],
            // 'logo_file',
            // 'completed_on',
            // 'completed_by_id',
            // 'created_on',
            // 'created_by_id',
            // 'updated_on',
            // 'updated_by_id',
            ],
        ]);
    }
    ?>

</div>
