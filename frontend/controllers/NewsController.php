<?php

namespace frontend\controllers;


use frontend\modules\admin\models\News;
use Yii;
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

    public function actionVoting($id){

        $model = News::findOne($id);
        /** @var News $model */

        $voteStatus = Yii::$app->request->post('voteStatus');

        $rating = $model->rating;

        if(Yii::$app->session->get('vote'))
            $arr = Yii::$app->session->get('vote');

        $arr[] = 'news' . $id;

        // записываем значение в сессию
        Yii::$app->session->set('vote', $arr);


        if($voteStatus == 'up')
        {
            $model->rating = $rating + 1;
        }
        else if($voteStatus == 'down')
        {
            $model->rating = $rating - 1;
        }

        $model->save();

        Yii::$app->response->redirect(['news/view','id'=>$model->id]);

    }


}