<?php

use yii\db\Schema;
use yii\db\Migration;

class m150730_133927_transfers_news extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('transfers_news', [
            'id' => Schema::TYPE_PK,
            'site' => Schema::TYPE_STRING,
            'old_id' => Schema::TYPE_INTEGER,
            'create_date' => Schema::TYPE_DATETIME,
            'title' => Schema::TYPE_TEXT,
            'content' => Schema::TYPE_TEXT,
            'image' => Schema::TYPE_TEXT,
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('transfers_news');
    }

}
