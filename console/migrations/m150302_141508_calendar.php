<?php

use yii\db\Schema;
use yii\db\Migration;

class m150302_141508_calendar extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('season', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'begin' => Schema::TYPE_DATE,
            'end' => Schema::TYPE_DATE,
            'league_id' => Schema::TYPE_INTEGER
        ], $tableOptions);
        $this->createIndex('league','season','league_id');
        $this->addForeignKey('league_season','season','league_id','league','id','RESTRICT','RESTRICT');
        $this->insert('season',['id'=>1,'title'=>'Eng D1 2013/2014','begin'=>'2013-07-30','end'=>'2014-05-20','league_id'=>1]);
        //$this->insert('season',['id'=>2,'title'=>'Rus D1 2013/2014','begin'=>'2013-06-15','end'=>'2014-05-20','league_id'=>2]);

        $this->createTable('season_club',[
            'id' => Schema::TYPE_PK,
            'club_id' => Schema::TYPE_INTEGER,
            'season_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->createIndex('club','season_club','club_id');
        $this->createIndex('season','season_club','season_id');
        $this->addForeignKey('club2season','season_club','club_id','club','id','RESTRICT','RESTRICT');
        $this->addForeignKey('season2club','season_club','season_id','season','id','RESTRICT','RESTRICT');

        for($i=1;$i<=20;$i++){
            $this->insert('season_club',['club_id'=>$i,'season_id'=>1]);
        }

        $this->createTable('tour', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'season_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->createIndex('season','tour','season_id');
        $this->addForeignKey('tour_season','tour','season_id','season','id','RESTRICT','RESTRICT');

        $this->createTable('match_result', [
            'id' => Schema::TYPE_PK,
            'value' => Schema::TYPE_STRING,
        ], $tableOptions);

        $this->insert('match_result',['id'=>1,'value'=>'не сыгран']);
        $this->insert('match_result',['id'=>2,'value'=>'победа 1']);
        $this->insert('match_result',['id'=>3,'value'=>'ничья']);
        $this->insert('match_result',['id'=>4,'value'=>'победа 2']);
        $this->insert('match_result',['id'=>5,'value'=>'отменен']);


        $this->createTable('match', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'team1' => Schema::TYPE_INTEGER,
            'team2' => Schema::TYPE_INTEGER,
            'result_id' => Schema::TYPE_INTEGER,
            'score' => Schema::TYPE_STRING,
            'tour_id' => Schema::TYPE_INTEGER
        ], $tableOptions);

        $this->createIndex('result','match','result_id');
        $this->createIndex('tour','match','tour_id');
        $this->addForeignKey('result_match','match','result_id','match_result','id','RESTRICT','RESTRICT');
        $this->addForeignKey('tour_match'  ,'match','tour_id','tour','id','RESTRICT','RESTRICT');

    }

    public function down()
    {
        echo "m140702_103730_calendar cannot be reverted.\n";
        $this->dropTable('match');
        $this->dropTable('match_result');
        $this->dropTable('tour');
        $this->dropTable('season_club');
        $this->dropTable('season');
    }
}
