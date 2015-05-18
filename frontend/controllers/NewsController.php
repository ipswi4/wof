<?php
/**
 * Created by PhpStorm.
 * User: kos
 * Date: 18.05.2015
 * Time: 20:15
 */

namespace frontend\controllers;


use frontend\modules\admin\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NewsController extends Controller {


    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionList()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => News::find(),
            'pagination' => [
                'pageSize' => 3,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
        ]);

        return $this->render('list',
            [
                'dataProvider'=>$dataProvider
            ]
        );

    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}