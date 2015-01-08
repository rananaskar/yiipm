<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Projectusers $model
 */

$this->title = $model->project_id;
$this->params['breadcrumbs'][] = ['label' => 'Projectusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projectusers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'project_id' => $model->project_id, 'user_id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'project_id' => $model->project_id, 'user_id' => $model->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'project_id',
            'user_id',
            'note:ntext',
            'role_id',
            'created_on',
            'created_by_id',
        ],
    ]) ?>

</div>
