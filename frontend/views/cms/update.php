<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Cms $model
 */

$this->title = 'Update CMS Page: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cms', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
