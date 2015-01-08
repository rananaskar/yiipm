<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var frontend\models\Companyusers $model
 */

$this->title = 'Edit Permission: ';
$this->params['breadcrumbs'][] = ['label' => 'Companyusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Edit Permissions";
?>
<div class="companyusers-permission">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
        $form="";
        foreach($projects as $id=>$name){
           $selected = isset($assigned_arr[$id])  ? "checked" : "";
            $form.="<span style='padding:10px; margin:5px'><input $selected name='companyusers[selected][]' type='checkbox' value='{$id}'></input>{$name}</span>";
            
        }
        echo $form;
    ?>
    
        <div><input type="submit" value="Save" name='companyusers[save]' class="btn btn-primary"></input></div>
    </form>
</div>
