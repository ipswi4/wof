<?php

use yii\db\Schema;
use yii\db\Migration;

class m150803_130729_players_info extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('players_info', [
            'id' => Schema::TYPE_PK,
            'old_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING,
            'transliteration' => Schema::TYPE_STRING,
            'birthday' => Schema::TYPE_DATE,
            'nationality' => Schema::TYPE_STRING,
            'team_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('players_info');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
