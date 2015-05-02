<?php
/* @var $this yii\web\View */
use common\models\Club;
use yii\helpers\Html;

/* @var Club[] $clubs */

?>
<h1>Free clubs</h1>
<div class="row">
    <table class="table">
        <?php foreach($clubs as $club): ?>
        <?php  /** @var Club $club */ ?>
        <tr>
            <td style="width: 80%;"><?= $club->title ?></td>
            <td>
                <?= Html::a('join',['manager/add','club'=>$club->id],['data-method'=>'post']); ?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>