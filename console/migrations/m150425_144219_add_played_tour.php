<?php

use yii\db\Schema;
use yii\db\Migration;

class m150425_144219_add_played_tour extends Migration
{
    public function up()
    {
        $this->addColumn('tour','played',Schema::TYPE_INTEGER."  NOT NULL");
    }

    public function down()
    {
        $this->dropColumn('tour','played');
    }
    
}
