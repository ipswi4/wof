<?php
/* @var $this yii\web\View */
/* @var $league \common\models\League */
use yii\helpers\Html;

?>

<div class="row league-index">
    <div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="table">
            <?php foreach($league->clubs as $club): ?>
            <tr>
                <td><?= $club->id; ?></td>
                <td><?= Html::a(Html::encode($club->title),['club/view','id'=>$club->id]) ?></td>
            </tr>
            <?php endforeach ?>
        </table>

</div>