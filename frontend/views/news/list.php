<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [

        'id',

        [
            'format' => 'html',
            'attribute' => 'title',
            'value' => function ($data) {
                return Html::a(Html::encode($data->title), ['news/view', 'id' => $data->id]);
            }, 'label' => 'Title'
        ],

        'text',
    ],
]); ?>