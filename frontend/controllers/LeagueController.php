<?php

namespace frontend\controllers;

use common\models\League;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class LeagueController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => League::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['league'=>$this->findModel($id)]);
    }

    protected function findModel($id)
    {
        if (($model = League::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
