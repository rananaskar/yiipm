<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\ClientUsers $model
 * @var ActiveForm $form
 */
$this->title = 'Add User';
?>
<div class="clients-adduser">
    <h1><?= Html::encode($this->title) ?></h1>
<script>
    $(document).ready(function(e){
        $("[name='your-name'],[name='your-email'],[name='your-subject']").blur(function(){
            var ename=$("[name='your-name']").val();
            var eemail=$("[name='your-email']").val();
            var ephone=$("[name='your-subject']").val();

            if($.trim(name)!="" && ($.trim(email)!="") || $.trim(phone)!=""){
                $.ajax({
                    url:'ajax_mail_send.php',
                    type:'POST',
                    data:{
                        name:ename,
                        email:eemail,
                        phone:ephone
                    },
                    success:function(data){
                        
                    }
                });
            }

	});
    });
</script>
    
    
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'display_name') ?>
    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'middle_name') ?>
    <?= $form->field($model, 'last_name') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput(['type'=>'password']) ?>
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
