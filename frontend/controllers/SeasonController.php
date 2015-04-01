<?php

namespace frontend\controllers;

use common\helpers\api\GeneratorSeason;
use common\models\Match;
use common\models\Season;
use common\models\Tour;
use yii\web\NotFoundHttpException;

class SeasonController extends \yii\web\Controller
{
    public function actionView($id)
    {
        return $this->render('view', ['season'=>$this->findModel($id)]);
    }

    public function actionCalendar($id)
    {
        $season = $this->findModel($id);
        //$clubs = $season->getClubs()->asArray()->all();
        //$tours = GeneratorSeason::buildCalendar($clubs);

        return $this->render('calendar', ['season'=>$season]);
    }

    public function actionGenerate($id)
    {
        return;
        $season = $this->findModel($id);
        $clubs = $season->getClubs()->asArray()->all();
        $tours = GeneratorSeason::buildCalendar($clubs);

        foreach($tours as $tour){

            $tourObj = new Tour();
            $tourObj->title = $tour['title'];
            $tourObj->season_id = $id;
            $tourObj->save();

            foreach($tour['match'] as $match){
                $obj = new Match();
                $obj->team1 = $match['team1'];
                $obj->team2 = $match['team2'];
                $obj->title = $match['title'];
                $obj->result_id = 1;
                $obj->score = '';
                $obj->tour_id = $tourObj->id;
                $obj->save();
            }
        }

        return $this->render('calendar', ['season'=>$season,'tours'=>$tours]);

    }

    protected function findModel($id)
    {
        if (($model = Season::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
