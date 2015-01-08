<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Project $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view?id=' . $model->id]];
$this->params['breadcrumbs'][] = "All Messages";
?>
<div class="project-view">
    <h1>All Messages</h1>
    <br/>
    <?= Html::a('New Message', ['newmessage?project_id=' . $model->id], ['class' => 'btn btn-success']) ?>
    <br/>
    <div class="panel" style="margin-top:20px;">
        <?php
        foreach ($messages as $key => $msg) {
            $msg_data = $msg['message_data'];
            ?>
            <div>
                <div class="panel-body" style="padding:0px; margin:0px; margin-top:16px; background-color: #f8f8f8; padding:20px">
                    <h4 style="margin:0px; font-weight: bolder; margin-bottom:10px;">
                        <?= $msg_data['title'] ?>
                    </h4>
                    <div class="panel-heading" style="padding:0px;">
                        <b><?= $msg_data['full_name'] ?></b> posted this on <?= date("d M Y", strtotime($msg_data['created_on'])) ?>
                    </div>
                    <?= $msg_data['text'] ?>
                    <div style="margin-top:40px;">
                        <a href="<?=Yii::$app->urlManager->createUrl("projects/viewmessage?message_id=".$msg_data['id'])?>">Go to message</a>
<!--                        | 3 comments (last by Ritwik Dasgupta on 10 Dec 2014)-->
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>