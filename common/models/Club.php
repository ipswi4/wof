<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "club".
 *
 * @property integer $id
 * @property string $title
 * @property integer $league_id
 *
 * @property League $league
 * @property Player[] $players
 */
class Club extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'club';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['league_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'league_id' => 'League ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeague()
    {
        return $this->hasOne(League::className(), ['id' => 'league_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Player::className(), ['club_id' => 'id']);
    }

    public function getSeasonClubs()
    {
        return $this->hasMany(SeasonClub::className(), ['season_id' => 'id']);
    }


    public function getSeasons()
    {
        return $this->hasMany(Season::className(), ['id','season_id'])
            ->via('SeasonClubs');;
    }
}
