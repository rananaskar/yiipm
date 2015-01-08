<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\Projectusers $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="projectusers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'role_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'created_by_id')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
