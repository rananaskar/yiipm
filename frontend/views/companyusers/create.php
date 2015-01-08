<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Companyusers $model
 */

$this->title = 'Create Companyusers';
$this->params['breadcrumbs'][] = ['label' => 'Companyusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companyusers-create">

    <h1>Create User</h1>

    <?= $this->render('_form', [
        'model' => $model,
	'timezone' => $timezone,
        'status' => $status,
    ]) ?>

</div>
