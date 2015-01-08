<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Project $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">
    <form class="form-horizontal" method="post" action="">
        <fieldset>
            <!-- Form Name -->
            <legend>Post A New Message</legend>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-2 control-label" for="title">Title</label>  
                <div class="col-md-8">
                    <input id="title" name="title" type="text" placeholder="Enter TItle" class="form-control input-md" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Message</label>  
                <div class="col-md-8">
                    <textarea class="form-control" name="message" id="message" required></textarea>
                    <label style="font-size: 13px; font-weight: normal;" for="post_private">
                        <strong>Private message?</strong>
                        <input name="post[private]" type="hidden" value="0">
                        <input class="privacy_toggle" id="post_private" name="post_private" type="checkbox" value="1">
                        Yes, make this visible only to your company
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-8">
                    <h4>Subscribe people to receive email notifications</h4>
                    <p style="color: #999;">
                        The people you select will get an email when you post this message.<br>
                        They’ll also be notified by email every time a comment is added.
                    </p>

                    <?php
                    $cli = 0;
                    foreach ($clients as $key => $clnt) {
                        ?>
                        <div>
                            <label>
                                <input data-target='inp-<?= $cli ?>' type="checkbox" class='inps' />
                                All of <?= $clnt['client_data']['name'] ?>
                            </label>
                            <div>
                                <?php
                                foreach ($clnt['user_data'] as $k => $usr) {
                                    ?>
                                    <label style="font-weight: normal;">
                                        <input name="users[]" value="<?= $usr['id'] ?>" class='inp-<?= $cli ?>' type="checkbox" />
                                        <?= $usr['first_name'] ?>
                                    </label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <br/>
                        <?php
                        $cli++;
                    }
                    ?>

                    <input type='submit' class='btn btn-success' value='Post this message' />
                    <input type='submit' class='btn btn-primary' value='Preview' />
                    or
                    <a href='#' class='btn btn-danger'>Cancel</a>

                </div>
            </div>
        </fieldset>
    </form>
</div>