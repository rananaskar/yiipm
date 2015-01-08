<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Projectusers $model
 */

$this->title = 'Update Projectusers: ' . $model->project_id;
$this->params['breadcrumbs'][] = ['label' => 'Projectusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->project_id, 'url' => ['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="projectusers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
