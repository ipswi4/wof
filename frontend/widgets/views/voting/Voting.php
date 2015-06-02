<?php

use yii\helpers\Html;

use frontend\modules\admin\models\News;


/**
 * @var $model News
 */


// проверяем значение в сессии
if($model->isVoting($model->id))
{
    ?>
    <h2><?= "Рейтинг: " . $model->rating; ?></h2>
    <?= "Вы уже проголосовали" ?>
<?
}
else
{
    ?>
    <?php \yii\widgets\Pjax::begin(['enablePushState' => false]); ?>
    <?= Html::a('', ['news/voting', 'voteStatus' => 'up', 'id' => $model->id], ['data-method'=>'POST','class' => 'btn btn-lg btn-warning glyphicon glyphicon-arrow-up']) ?>
    <h2><?= "Рейтинг: " . $model->rating; ?></h2>
    <?= Html::a('', ['news/voting', 'voteStatus' => 'down', 'id' => $model->id], ['data-method'=>'POST','class' => 'btn btn-lg btn-primary glyphicon glyphicon-arrow-down']) ?>
    <? \yii\widgets\Pjax::end() ?>
<?
}
?>

