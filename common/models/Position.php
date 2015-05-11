<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "position".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Player[] $players
 */
class Position extends \yii\db\ActiveRecord
{

    const GK = 1;
    const LD = 2;
    const CD = 3;
    const RD = 4;
    const LM = 5;
    const CM = 6;
    const RM = 7;
    const CF = 8;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Player::className(), ['position_id' => 'id']);
    }
}
