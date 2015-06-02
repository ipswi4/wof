<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_165318_tag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('tag', [
            'id' => Schema::TYPE_PK,
            'frequency' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('tag');
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
