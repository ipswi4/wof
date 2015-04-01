<?php
/* @var $this yii\web\View */
/* @var $season \common\models\Season */
use yii\helpers\Html;

?>
<?= Html::a('[calendar]',['season/calendar','id'=>$season->id]) ?>
<div class="row league-index">
    <div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="table">
            <?php foreach($season->clubs as $club): ?>
                <tr>
                    <td><?= $club->id; ?></td>
                    <td><?= Html::a(Html::encode($club->title),['club/view','id'=>$club->id]) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>