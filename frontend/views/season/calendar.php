<?php
/* @var $this yii\web\View */
/* @var $season \common\models\Season */
/* @var array $tours */
use yii\helpers\Html;

?>
<?= Html::a('[season]',['season/view','id'=>$season->id]) ?>
<div class="row">
    <div class="col-md-6">
        <?= \frontend\widgets\Standings::widget(['season'=>$season]) ?>
    </div>
</div>
<div class="row league-index">
    <?php foreach($season->tours as $tour): ?>
        <div class="col-md-4" style="margin-top: 20px;">
            <h4><?= $tour->title ?></h4>
            <table class="table table-bordered">
                <?php foreach($tour->matches as $match):?>
                <tr>
                    <td><?= $match->title ?></td>
                    <td style="text-align: center;"><?= $match->getTextScore() ?></td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    <?php endforeach ?>
</div>