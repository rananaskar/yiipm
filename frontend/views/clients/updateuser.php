<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\ClientUsers $model
 * @var ActiveForm $form
 */
$this->title = 'Edit Client User';
?>
<div class="clients-adduser">
    <h1><?= Html::encode($this->title) ?></h1>    
    
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'display_name') ?>
    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'middle_name') ?>
    <?= $form->field($model, 'last_name') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'username') ?>
    <?php
    echo $form->field($model, 'timezone')->dropDownList($timezone, ['prompt' => 'None']);
    ?>
    <?= $form->field($model, 'office_number') ?>
    <?= $form->field($model, 'fax_number') ?>
    <?= $form->field($model, 'mobile_number') ?>
    <?= $form->field($model, 'home_number') ?>
    <?= $form->field($model, 'department_details') ?>
    <div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
        <?php ActiveForm::end(); ?>
</div>
