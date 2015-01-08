<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\Cms $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.4.5.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function(e){
        
    });
</script>
<div class="cms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'keyword')->textarea(['rows' => 6]) ?>

    <?php // echo $form->field($model, 'pagename')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'pagedetails')->textarea(['rows' => 6,'class'=>'ckeditor']) ?>

    <?= $form->field($model, 'status')->dropDownList(array("1"=>"Active","0"=>"Inactive")) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
