<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Client $model
 */

$this->title = 'Add Client';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'timezone' => $timezone,
        'country'=>$country,
        'model' => $model,
    ]) ?>

</div>
