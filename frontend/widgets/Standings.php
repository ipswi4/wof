<?php

namespace frontend\widgets;

use common\models\Club;
use common\models\MatchResult;
use common\models\Season;
use yii\helpers\ArrayHelper;

/**
 * Class Standings
 * @package frontend\widgets
 *
 * @property Season $season
 */
class Standings extends \yii\bootstrap\Widget{

    public $season;

    public function run() {

        $tours = $this->season->playersTours;
        $clubs = $this->season->clubs;

        $scoreTable = [];

        foreach ($clubs as $club) {
            /** @var Club $club */

            $scoreTable[$club->id] = [
                'title'=>$club->title,
                'point'=>0,
                'sc'=>0, // забито
                'sk'=>0,  // пропущено
                'pl'=>0 // игр сыграно
            ];
        }

        foreach($tours as $tour){
            foreach($tour->matches as $match){

                \Yii::warning($match->score);
                list($g1,$g2) = explode(":",$match->score);

                $scoreTable[$match->team1]['sc'] += $g1;
                $scoreTable[$match->team2]['sc'] += $g2;

                $scoreTable[$match->team1]['sk'] += $g2;
                $scoreTable[$match->team2]['sk'] += $g1;

                $scoreTable[$match->team1]['pl']++;
                $scoreTable[$match->team2]['pl']++;

                if ($match->result_id == MatchResult::WIN1)
                    $scoreTable[$match->team1]['point'] += 3;

                if ($match->result_id == MatchResult::WIN2)
                    $scoreTable[$match->team2]['point'] += 3;

                if ($match->result_id == MatchResult::DRAW) {
                    $scoreTable[$match->team1]['point'] += 1;
                    $scoreTable[$match->team2]['point'] += 1;
                }
            }
        }

        ArrayHelper::multisort($scoreTable,'point',SORT_DESC);

        return $this->render('standings',['scoreTable'=>$scoreTable]);
    }


}