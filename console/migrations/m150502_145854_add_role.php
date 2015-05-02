<?php

use yii\db\Schema;
use yii\db\Migration;

class m150502_145854_add_role extends Migration
{
    public function up()
    {
        $this->addColumn('user','role',Schema::TYPE_INTEGER.' NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('user','role');
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
