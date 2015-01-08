<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

//use frontend\controllers\AdminController;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            .glyphicon-eye-open{
                display: none;
            }
        </style>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="wrap">

            <nav class="navbar-inverse navbar-fixed-top navbar" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="">Admin</a>
                    </div>
                    <div id="w0-collapse" class="collapse navbar-collapse">
                        <?php
                        if (Yii::$app->user->isGuest == false) {
                            ?>
                            <ul id="w1" class="navbar-nav navbar-right nav">
                                <li><a href="<?php echo Yii::$app->urlManager->createUrl("/projects/index"); ?>">My Projects</a></li>
                                <?php
                                if (Yii::$app->session->get("isAdmin")) {
                                    ?>
                                    <li><a href="<?php echo Yii::$app->urlManager->createUrl("/clients/index"); ?>">Clients</a></li>
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Administration <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Company</a></li>
                                            <li><a href="#">Edit Company</a></li>
                                            <li><a href="<?php echo Yii::$app->urlManager->createUrl("/clients/index"); ?>">Clients</a></li>
                                            <li><a href="<?php echo Yii::$app->urlManager->createUrl("/clients/create"); ?>">Add Clients</a></li>
                                            <li><a href="<?php echo Yii::$app->urlManager->createUrl("/projects/index"); ?>">Projects</a></li>
											<li><a href="<?php echo Yii::$app->urlManager->createUrl("/companyusers"); ?>">Add/Edit Users</a></li>
                                            <li><a href="#">Time</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Trash</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">View Admin</a></li>
                                    <?php
                                }
                                ?>
                                <li><a href="<?php echo Yii::$app->urlManager->createUrl("/site/logout"); ?>" data-method="post">Logout (admin)</a></li>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>

            <div class="navbar-inverse navbar">
                
            </div>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
                <!--<p class="pull-right"><?= Yii::powered() ?></p>-->
            </div>
        </footer>

        <?php $this->endBody() ?>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//cdn.ckeditor.com/4.4.5.1/standard/ckeditor.js"></script>
    </body>
</html>
<?php $this->endPage() ?>