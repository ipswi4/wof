<?php

use frontend\modules\admin\models\News;
use frontend\modules\admin\models\Comment;
use frontend\modules\admin\models\CommentForm;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/**
 * @var $model News
 * @var $formModel CommentForm
 */

?>

<?php
$js = <<<JS
    $("document").ready(function(){
            $(".pjax-comment").on("pjax:end", function() {
                $("#msg-comment").html("");
                $.pjax.reload();
            });
        });
JS;
$this->registerJs($js);
?>

<?php \yii\widgets\Pjax::begin(['options' => ['class' => 'pjax-comment']]); ?>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?php foreach($model->comments as $comment): ?>
            <div class="row">
                <?= "Author: " . Html::encode($comment->author) ?>
            </div>

            <div class="row">
                <?= "Comment: " . Html::encode($comment->text) ?>
            </div>

            <br />

        <?php endforeach ?>


        <?= $form->field($formModel, 'author')->label('Author') ?>

        <?= $form->field($formModel, 'text')->textarea(['id'=>'msg-comment'])->label('Comment') ?>

        <?= $form->field($formModel, 'captcha')->widget(Captcha::className()) ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'data-pjax' => '0']) ?>
        </div>

    <?php ActiveForm::end(); ?>

<?php \yii\widgets\Pjax::end(); ?>

