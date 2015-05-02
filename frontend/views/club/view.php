<?php
/* @var $this yii\web\View */
/* @var $club \common\models\Club */
use yii\helpers\Html;

?>
<div class="row">
    <?php
        if ($club->user){
            echo "Тренер: ".$club->user->username;
        } else echo "Тренера нет";

    ?>
</div>
<div class="row league-index">
    <div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="table">
            <tr>
                <th>Позиция</th>
                <th>Имя</th>
                <th>Возраст</th>
                <th>Сила</th>
            </tr>
            <?php foreach($club->players as $player): ?>
            <tr>
                <td><?= $player->position->title ?></td>
                <td><?= Html::encode($player->first_name." ".$player->last_name) ?></td>
                <td><?= $player->age ?></td>
                <td><?= $player->power  ?></td>
            </tr>
            <?php endforeach ?>
        </table>

</div>