<?php
/* @var $this yii\web\View */
?>
<h1>players-info/index</h1>


<ul>
    <?php foreach ($players as $player): ?>
        <li>
            <?= $player->old_id . ' ' .  $player->name . ' ' . $player->transliteration . ' ' . $player->birthday . ' ' . $player->nationality . ' ' . $player->team_id?>
            <br />
            <br />
        </li>
        <br />
    <?php endforeach; ?>
</ul>
