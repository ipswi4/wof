<?php
/* @var $this yii\web\View */
/* @var $league \common\models\League */
/* @var array $tours */
use yii\helpers\Html;

?>
<?php Html::a('[calendar]',['league/calendar','id'=>$league->id]) ?>
<div class="row league-index">
    <div class="col-md-6">
        <h2>Сезоны</h2>
        <?php foreach($league->seasons as $season): ?>
            <?= Html::a(Html::encode($season->title),['season/view','id'=>$season->id]) ?>
        <?php endforeach ?>
    </div>
</div>