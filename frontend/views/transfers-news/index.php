<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

?>
<h1>transfers-news/index</h1>


<ul>
    <?php foreach ($news as $one_news): ?>
        <li>
            <?= $one_news->create_date ?>
            <br />
            <br />
            <?= $one_news->content ?>
            <br />
        </li>
        <br />
    <?php endforeach; ?>
</ul>