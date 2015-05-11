<?php

namespace frontend\controllers;

use common\helpers\api\GeneratorSeason;
use common\models\League;
use common\models\Match;
use common\models\MatchResult;
use common\models\Season;
use common\models\Tour;
use common\models\Player;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class SeasonController extends \yii\web\Controller
{

    protected $powerSum;


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

            // определяем номер команды
            $team1 = $match->team1;
            $team2 = $match->team2;

            // находим сумму power команд
            $powerSum1 = $this->findPowerTeam($team1);
            $powerSum2 = $this->findPowerTeam($team2);


            if ($powerSum1>$powerSum2){
                $score1 = rand(2,5);
                $score2 = rand(0,1);
                $match->result_id = MatchResult::WIN1;
            }

            if ($powerSum1==$powerSum2){
                $score1 = rand(2,5);
                $score2 = $score1;
                $match->result_id = MatchResult::DRAW;
            }

            if ($powerSum1<$powerSum2){
                $score1 = rand(0,1);
                $score2 = rand(2,5);
                $match->result_id = MatchResult::WIN2;
            }

            $match->score = $score1.":".$score2;

            $match->save();


            /*
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
            */
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


    protected function findPowerTeam($team)
    {
        $gk = [];
        $ld = [];
        $cd = [];
        $rd = [];
        $lm = [];
        $cm = [];
        $rm = [];
        $cf = [];

        $powerSum = 0;

        // находим всех игроков данного клуба, сортируя по power
        $allPlayers = Player::find()
            ->where(['club_id' => $team])
            ->orderBy('power')
            ->all();

        foreach($allPlayers as $player)
        {
            if($player['position_id'] == 1)
            {
                $gk[] = $player['power'];
            }

            if($player['position_id'] == 2)
            {
                $ld[] = $player['power'];
            }

            if($player['position_id'] == 3)
            {
                $cd[] = $player['power'];
            }

            if($player['position_id'] == 4)
            {
                $rd[] = $player['power'];
            }

            if($player['position_id'] == 5)
            {
                $lm[] = $player['power'];
            }

            if($player['position_id'] == 6)
            {
                $cm[] = $player['power'];
            }

            if($player['position_id'] == 7)
            {
                $rm[] = $player['power'];
            }

            if($player['position_id'] == 8)
            {
                $cf[] = $player['power'];
            }

        }

        $powerSum = $gk[0] + $ld[0] + $cd[0] + $cd[1] + $rd[0] + $lm[0] + $cm[0] + $cm[1] + $rm[0] + $cf[0] + $cf[1];

        return $powerSum;
    }

}
