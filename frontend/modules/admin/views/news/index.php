<?php

use frontend\modules\admin\models\News;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


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
                },
                'label' => 'Title',
            ],

            [
                'format' => 'html',
                'attribute' => 'text',
                'value'=> function($data){
                    return $data->text;
                }
            ],

            [
                'format' => 'html',
                'attribute' => 'tags',
                'value'=> function($data){
                    /** @var News $data */
                    return $data->getGenresText();
                },
                'label' => 'Tags',
            ],

            'image',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
