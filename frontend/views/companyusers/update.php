<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Companyusers $model
 */

$this->title = 'Update Companyusers: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Companyusers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="companyusers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'timezone' => $timezone,
        'id'=>$id,
        'status'=>$status
    ]) ?>

</div>
