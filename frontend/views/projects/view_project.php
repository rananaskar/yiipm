<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Project $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">
    <h1><?=$model->name?></h1>
    <br/>
    <?= Html::a('Messages', ['messages?project_id='.$model->id], ['class' => 'btn btn-success']) ?>
    
</div>