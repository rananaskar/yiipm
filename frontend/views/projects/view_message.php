<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Project $model
 */
$this->title = "View Message";
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $project_data['name'];
$this->params['breadcrumbs'][] = "Messages";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">
    <fieldset>
        <legend><b><?= $message_data['title'] ?></b></legend>
        <span><span style="color:#999;">From:</span> <?= $message_data['full_name'] ?></span>
        <br/>
        <span><span style="color:#999;">Date:</span> <?= date("D, d M Y", strtotime($message_data['created_on'])) . " at " . date("h:i a", strtotime($message_data['created_on'])) ?></span>
        <hr/>
        <br/>
        <?= $message_data['text'] ?>
        <br/>
        <div>
            <h5 style="font-weight: bold; border-bottom: solid 1px #f2f2f2; padding-bottom: 10px;">Comments</h5>
            <div style="padding:10px; padding-left: 4px; background-color: #fcfcfc;">
                <?php
                foreach ($comments as $ck => $comm) {
                    $comment = $comm['comment_data'];
                    ?>
                    <div style="border-bottom: solid 1px #f2f2f2; padding-bottom: 30px">
                        <b><?= $comment['full_name'] ?></b> <span style="color:#999;"><?= date("D, d M Y", strtotime($comment['created_on'])) . " at " . date("h:i a", strtotime($comment['created_on'])) ?></span>
                        <div>
                            <?= $comment['text'] ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <br/>
                <!--<hr/>-->
                <h5 style="font-weight: bold;">Leave A Comment</h5>
                <form class="form-horizontal" method="post" action="">
                    <textarea class="form-control" name="comment" id="message"></textarea>
                    <br/>
                    <input type="file" name="attachment" data-badge="false" />
                    <br/>
                    <input type="submit" class="btn btn-primary" value="Post Comment" />
                </form>
            </div>
        </div>
    </fieldset>
</div>