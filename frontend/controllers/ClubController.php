<?php

namespace frontend\controllers;

use common\models\Club;
use yii\web\NotFoundHttpException;

class ClubController extends \yii\web\Controller
{
    public function actionView($id)
    {
        return $this->render('view', ['club'=>$this->findModel($id)]);
    }

    protected function findModel($id)
    {
        if (($model = Club::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
