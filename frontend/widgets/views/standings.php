<?php
/**
 * @var View $this
 * @var array $scoreTable
 */
use yii\web\View;

?>
<table class="table table-bordered">
    <tr>
        <th>Title</th>
        <th>Played</th>
        <th>Scored</th>
        <th>Skipped</th>
        <th>Diff</th>
        <th>Point</th>
    </tr>
    <?php foreach ($scoreTable as $k => $club): ?>
        <tr>
            <td><?= $club['title'] ?></td>
            <td><?= $club['pl'] ?></td>
            <td><?= $club['sc'] ?></td>
            <td><?= $club['sk'] ?></td>
            <td><?= ($club['sc'] - $club['sk'] ) ?></td>
            <td><?= $club['point'] ?></td>
        </tr>
    <? endforeach ?>
</table>