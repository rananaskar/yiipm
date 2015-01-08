<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\Companyusers $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="companyusers-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => 50]) ?>

<?= $form->field($model, 'password')->textInput(['maxlength' => 50]) ?>

    <!--   <?= $form->field($model, 'use_gravatar')->textInput() ?> -->

    <!--  <?= $form->field($model, 'is_favorite')->textInput() ?> -->

    <?= $form->field($model, 'timezone')->dropDownList($timezone, ['prompt' => 'None']) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <!--   <?= $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>  -->

    <!--   <?= $form->field($model, 'avatar_file')->fileInput() ?> -->

    <?= $form->field($model, 'office_number')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'fax_number')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => 50]) ?>

<?= $form->field($model, 'home_number')->textInput(['maxlength' => 50]) ?>

    <!--   <?= $form->field($model, 'license_plate')->textInput(['maxlength' => 50]) ?>  -->

    <!--   <?= $form->field($model, 'food_preferences')->textInput(['maxlength' => 50]) ?> -->

    <?= $form->field($model, 'department_details')->textInput(['maxlength' => 50]) ?>

<?= $form->field($model, 'location_details')->textInput(['maxlength' => 50]) ?>

    <!--  <?= $form->field($model, 'language_preferences')->textInput(['maxlength' => 50]) ?> -->

<?= $form->field($model, 'status')->dropDownList($status,['prompt' => 'None']) ?>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
