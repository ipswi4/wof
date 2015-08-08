<?php

use yii\helpers\Html;

use frontend\modules\admin\models\News;


/**
 * @var $model News
 */
?>


<?php \yii\widgets\Pjax::begin(['enablePushState' => false]); ?>

<?php if (!$model->isVoting($model->id)): ?>

    <?= Html::a('', ['news/voting', 'voteStatus' => 'up', 'id' => $model->id], ['class' => 'btn btn-lg btn-warning glyphicon glyphicon-arrow-up']) ?>
    <h2><?= "Рейтинг: " . $model->rating; ?></h2>
    <?= Html::a('', ['news/voting', 'voteStatus' => 'down', 'id' => $model->id], ['class' => 'btn btn-lg btn-primary glyphicon glyphicon-arrow-down']) ?>

<?php else: ?>

    <h2><?= "Рейтинг: " . $model->rating; ?></h2>
    <?= "Вы уже проголосовали" ?>
<?php endif ?>
<? \yii\widgets\Pjax::end() ?>

