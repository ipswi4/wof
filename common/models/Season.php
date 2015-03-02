<?php

namespace common\models;

use Yii;


/**
 * This is the model class for table "season".
 *
 * @property integer $id
 * @property string $title
 * @property string $begin
 * @property string $end
 * @property integer $league_id
 * @property Club[] $clubs
 *
 * @property League $league
 * @property Tour[] $tours
 */
class Season extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'season';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['begin', 'end'], 'safe'],
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
            'begin' => 'Begin',
            'end' => 'End',
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
    public function getClubs()
    {
        return $this->hasMany(Club::className(), ['id' => 'club_id'])
            ->viaTable('season_club', ['season_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTours()
    {
        return $this->hasMany(Tour::className(), ['season_id' => 'id']);
    }
}
