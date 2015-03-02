<?php

use yii\db\Schema;
use yii\db\Migration;

class m150302_140532_data_generate extends Migration
{
    public function up()
    {
        $positions = [
            'GK',
            'LD',
            'CD',
            'RD',
            'LM',
            'CM',
            'RM',
            'CF'
        ];

        foreach($positions as $k=>$position){
            $model = new \common\models\Position();
            $model->id = $k+1;
            $model->title = $position;
            $model->save();
        }

        $model = new \common\models\League();
        $model->id = 1;
        $model->title = 'Barclays Premier League';
        $model->save();

        $clubs = [
            'Арсенал',
            'Челси',
            'Ливерпуль',
            'Манчестер Сити',
            'Тоттенхэм',
            'Манчестер Юнайтед',
            'Эвертон',
            'Ньюкасл',
            'Саутгемптон',
            'Вест Хэм',
            'Астон Вилла',
            'Сток Сити',
            'Халл',
            'Суонси',
            'Норвич',
            'Кристал Пэлас',
            'Вест Бромвич',
            'Кардифф',
            'Сандерленд',
            'Фулхэм'
        ];

        foreach($clubs as $k=>$club){
            $model = new \common\models\Club();
            $model->id = $k+1;
            $model->title = $club;
            $model->league_id = 1;
            $model->save();

            for ($i = 0; $i<=22; $i++){
                $player = new \common\models\Player();
                $player->first_name = \backend\models\NameGenerator::getRandomFirstName();
                $player->last_name = \backend\models\NameGenerator::getRandomLastName();

                $player->club_id = $model->id;

                switch ($i) {
                    case 0:
                    case 1:
                        $player->position_id = 1;
                        break;
                    case 2:
                    case 3:
                        $player->position_id = 2;
                        break;
                    case 4:
                    case 5:
                        $player->position_id = 4;
                        break;
                    case 6:
                    case 7:
                        $player->position_id = 5;
                        break;
                    case 8:
                    case 9:
                        $player->position_id = 7;
                        break;
                    case 10:
                    case 11:
                    case 12:
                    case 13:
                    case 14:
                        $player->position_id = 3;
                        break;
                    case 15:
                    case 16:
                    case 17:
                    case 18:
                    case 19:
                        $player->position_id = 6;
                        break;
                    case 20:
                    case 21:
                    case 22:
                        $player->position_id = 8;
                        break;
                }

                $player->age = rand(18,33);

                $koef = 0;
                if ($k<7) $koef = 15;
                $player->power = rand(50,84)+$koef;

                $player->save();

            }
        }
    }


    public function down()
    {
        \common\models\Club::deleteAll();
        \common\models\League::deleteAll();
        \common\models\Player::deleteAll();
        \common\models\Position::deleteAll();
    }
}
