<?php

use common\models\Club;
use yii\db\Schema;
use yii\db\Migration;

class m150302_141530_season_generate extends Migration
{
    public function up()
    {
        $clubs = Club::find()->asArray()->all();
        $tours = \common\helpers\api\GeneratorSeason::buildCalendar($clubs);

        foreach($tours as $tour){
            $this->insert("tour",['title'=>$tour['title'],'season_id'=>1]);
            $tour_id = $this->db->lastInsertID;
            foreach($tour['match'] as $item){
                $this->insert('match',[
                    'title'=>$item['title'],
                    'team1'=>$item['team1'],
                    'team2'=>$item['team2'],
                    'result_id'=>1,
                    'score'=>'',
                    'tour_id'=>$tour_id
                ]);
            }
        }
    }

    public function down()
    {
        echo "m140703_101029_season_generate cannot be reverted.\n";

        //return false;
    }
}
