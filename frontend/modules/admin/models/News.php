<?php

namespace frontend\modules\admin\models;

use common\models\Tag;
use dosamigos\taggable\Taggable;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property array $tags
 * @property string $image
 */
class News extends \yii\db\ActiveRecord
{

    public $file;


    public function behaviors() {
        return [
            [
                'class' => Taggable::className(),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['tagNames'], 'safe'],
            [['file'], 'file'],
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
            'text' => 'Text',
            'file' => 'Image',
        ];
    }

    /**
     * @property Comment[] $comments
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['id_news' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('news_tag_assn', ['news_id' => 'id']);
    }


    public function getGenresText()
    {
        return implode(',', ArrayHelper::map($this->tags,'id','name'));
    }


}
