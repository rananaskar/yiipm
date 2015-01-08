<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\Clients $searchModel
 */
$this->title = 'Edit Permission';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading">Hint</div>
        <div class="panel-body">
            <p>
                Check which projects this company can access. Note that you'll also need to specify access permissions for company members that you want to be able to access and manage selected projects (you can do that through the project's People page or through user profiles).
            </p>
        </div>
    </div>

    <form action="" method="post">
        <table class="table table-bordered table-striped">
            <?php
            foreach ($my_projects as $k => $proj) {
                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="proj[]" <?php
                        if ($proj['checked'] == true) {
                            echo "checked='checked'";
                        }
                        ?> value="<?= $proj['id'] ?>" />
                    </td>
                    <td>
                        <?= $proj['name'] ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
        <input type="submit" value="Edit Permission" class="btn btn-success" />
    </form>
</div>
