<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "match_result".
 *
 * @property integer $id
 * @property string $value
 *
 * @property Match[] $matches
 */
class MatchResult extends \yii\db\ActiveRecord
{

    const NO_PLAYED = 1;
    const WIN1 = 2;
    const DRAW = 3;
    const WIN2 = 4;
    const CANCELED = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'match_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches()
    {
        return $this->hasMany(Match::className(), ['result_id' => 'id']);
    }
}
