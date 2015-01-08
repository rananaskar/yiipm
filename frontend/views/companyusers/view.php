<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var frontend\models\Companyusers $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Companyusers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companyusers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'company_id',
            'user_id',
            'email:email',
            'display_name',
            'first_name',
            'middle_name',
            'last_name',
            'title',
            'avatar_file',
            'use_gravatar',
            'is_favorite',
            'timezone:datetime',
            'office_number',
            'fax_number',
            'mobile_number',
            'home_number',
            'license_plate',
            'food_preferences',
            'department_details',
            'location_details',
            'language_preferences',
            'created_on',
            'created_by_id',
            'updated_on',
            'updated_by_id',
        ],
    ]) ?>

</div>
