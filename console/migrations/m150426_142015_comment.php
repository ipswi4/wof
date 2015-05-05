<?php

use yii\db\Schema;
use yii\db\Migration;

class m150426_142015_comment extends Migration
{
    public function up()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('comment', [
            'id' => Schema::TYPE_PK,
            'id_news' => Schema::TYPE_INTEGER,
            'author' => Schema::TYPE_STRING,
            'text' => Schema::TYPE_TEXT
        ], $tableOptions);

        $this->addForeignKey('comment_news',                // название связи
                             'comment', 'id_news',          // какое поле соединяем
                             'news', 'id',                  // с каким полем
                             'RESTRICT','RESTRICT');

    }

    public function down()
    {
        $this->dropForeignKey('comment_news','comment');
        $this->dropTable('comment');
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

?>



