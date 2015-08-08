<?php

namespace frontend\controllers;



use frontend\models\TransfersNews;


class TransfersNewsController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $tNews = new TransfersNews();

        $news = $tNews->getTransfersNews();

        return $this->render('index', [
            'news' => $news
        ]);
    }

    public function actionGoal()
    {
        $tNews = new TransfersNews();

        $tNews->generateTransferNews();
    }




}
