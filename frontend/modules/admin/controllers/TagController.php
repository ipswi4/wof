<?php

namespace frontend\modules\admin\controllers;


use common\models\Tag;
use Yii;
use yii\web\Response;



class TagController extends DashboardController
{

    // actionList to return matched tags
    public function actionList($query)
    {
        $models = Tag::find()->where(['like', 'name', urldecode($query)])->all();
        $items = [];

        foreach ($models as $model) {
            $items[] = ['name' => $model->name];
        }
        // We know we can use ContentNegotiator filter
        // this way is easier to show you here :)
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $items;
    }

}