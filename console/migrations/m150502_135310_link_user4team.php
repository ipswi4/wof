<?php

use yii\db\Schema;
use yii\db\Migration;

class m150502_135310_link_user4team extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user','club_id',Schema::TYPE_INTEGER);

        $this->addForeignKey('user4team','user','club_id','club','id','RESTRICT','RESTRICT');

    }

    public function safeDown()
    {
        $this->dropForeignKey('user4team','user');

        $this->dropColumn('user','club_id');

    }
}
