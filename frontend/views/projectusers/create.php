<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Projectusers $model
 */

$this->title = 'Create Projectusers';
$this->params['breadcrumbs'][] = ['label' => 'Projectusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projectusers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
