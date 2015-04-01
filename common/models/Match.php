<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "match".
 *
 * @property integer $id
 * @property string $title
 * @property integer $team1
 * @property integer $team2
 * @property integer $result_id
 * @property string $score
 * @property integer $tour_id
 *
 * @property Tour $tour
 * @property MatchResult $result
 * @property MatchStatus $status
 */
class Match extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team1', 'team2', 'result_id', 'tour_id'], 'integer'],
            [['title', 'score'], 'string', 'max' => 255]
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
            'team1' => 'Team1',
            'team2' => 'Team2',
            'status_id' => 'Status ID',
            'result_id' => 'Result ID',
            'score' => 'Score',
            'tour_id' => 'Tour ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tour_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(MatchResult::className(), ['id' => 'result_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(MatchStatus::className(), ['id' => 'status_id']);
    }

    public function getTextScore()
    {
        return ($this->result->id == MatchResult::NO_PLAYED) ? '0 - 0' : $this->score;
    }
}
