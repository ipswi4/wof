<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\BaseDataProvider */
use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="row league-index">
    <div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'=>"{items}\n{pager}",
            'columns' => [
                'id',
                [
                    'label'=>'Title',
                    'format'=>'html',
                    'value'=>function($data){
                        return Html::a($data->title,['league/view','id'=>$data->id]);
                    }
                ],
            ],
        ]); ?>
    </div>

</div>