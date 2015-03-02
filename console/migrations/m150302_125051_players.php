<?php

use yii\db\Schema;
use yii\db\Migration;

class m150302_125051_players extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('league', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING
        ], $tableOptions);

        $this->createTable('position', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING
        ], $tableOptions);

        $this->createTable('club',[
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'league_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->addForeignKey('league_link','club','league_id','league','id','RESTRICT','RESTRICT');


        $this->createTable('player', [
            'id' => Schema::TYPE_PK,
            'first_name' => Schema::TYPE_STRING . ' NOT NULL',
            'last_name' => Schema::TYPE_STRING . ' NOT NULL',
            'age' => Schema::TYPE_INTEGER. ' NOT NULL',
            'power' => Schema::TYPE_INTEGER,
            'position_id' => Schema::TYPE_INTEGER,
            'club_id' => Schema::TYPE_INTEGER
        ], $tableOptions);

        $this->addForeignKey('position_link','player','position_id','position','id','RESTRICT','RESTRICT');
        $this->addForeignKey('club_link','player','club_id','club','id','RESTRICT','RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('position_link','player');
        $this->dropForeignKey('club_link','player');
        $this->dropForeignKey('league_link','club');

        $this->dropTable('player');
        $this->dropTable('position');
        $this->dropTable('club');
        $this->dropTable('league');
    }

}
