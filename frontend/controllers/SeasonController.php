<?php

namespace frontend\controllers;

use common\helpers\api\GeneratorSeason;
use common\models\League;
use common\models\Match;
use common\models\MatchResult;
use common\models\Season;
use common\models\Tour;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

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

    public function actionNextGame()
    {
        $season = Season::findOne(1);
        /** @var Season $season */

        /** @var Tour $nextTour */
        $nextTour = $season->nextTour;

        if (!$nextTour) throw new ServerErrorHttpException("season is over");

        $matches = $nextTour->matches;

        foreach($matches as $match){

            $score1 = rand(0,5);
            $score2 = rand(0,5);

            if ($score1>$score2){
                $match->result_id = MatchResult::WIN1;
            }

            if ($score1==$score2){
                $match->result_id = MatchResult::DRAW;
            }

            if ($score1<$score2){
                $match->result_id = MatchResult::WIN2;
            }

            $match->score = $score1.":".$score2;

            $match->save();
        }

        $nextTour->played = Tour::PLAYED;
        $nextTour->save();

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
