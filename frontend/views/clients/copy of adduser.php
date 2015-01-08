<?php

$this->title="Add New User";

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options'=>['autocomplete'=>'off']]); ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 256]) ?>
    
    <?php //echo $form->field($model, 'gender')->dropDownList(array("Male"=>"Male","Female"=>"Female")) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
