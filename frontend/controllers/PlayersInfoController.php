<?php

namespace frontend\controllers;

use frontend\models\PlayersInfo;

class PlayersInfoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $pInfo = new PlayersInfo();

        $players = $pInfo->getPlayersInfo();

        return $this->render('index', [
            'players' => $players
        ]);
    }

    public function actionInfo()
    {
        $pInfo = new PlayersInfo();

        $pInfo->generatePlayersInfo();
    }

}
