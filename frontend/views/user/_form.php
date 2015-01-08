<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options'=>['autocomplete'=>'off']]); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'dob')->input('date') ?>
    
    <?= $form->field($model, 'gender')->dropDownList(array("Male"=>"Male","Female"=>"Female")) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
