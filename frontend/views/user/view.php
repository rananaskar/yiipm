<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 */
$this->title = "View User Details";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fullname',
            'email:email',
            'username',
        ],
    ])
    ?>

</div>
<div class="user-view">
    <h1><?= Html::encode("Consume Report") ?></h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Consume Date</th>
            <th>Total Calory</th>
            <th>Total Sugar</th>
            <th>Total Fat</th>
            <th>Total Protein</th>
            <th>Foods</th>
        </tr>
        <?php
        foreach ($consumption_detail as $key => $val) {
            ?>
            <tr>
                <td>
                    <?php echo $val['date']; ?>
                </td>
                <td>
                    <?php echo $val['t_cal']; ?>
                </td>
                <td>
                    <?php echo $val['t_sugar']; ?>
                </td>
                <td>
                    <?php echo $val['t_fat']; ?>
                </td>
                <td>
                    <?php echo $val['t_protein']; ?>
                </td>
                <td>
                    <?php echo $val['foods']; ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
