<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_130603_alter_rating_news extends Migration
{
    public function up()
    {

        $this->alterColumn('news','rating', Schema::TYPE_INTEGER, 'NOT NULL DEFAULT 0');

    }

    public function down()
    {

    }
    

}
