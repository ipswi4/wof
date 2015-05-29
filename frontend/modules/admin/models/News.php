<?php

namespace frontend\modules\admin\models;

use common\models\Tag;
use dosamigos\taggable\Taggable;
use Yii;
use yii\helpers\ArrayHelper;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;

use yii\web\UploadedFile;


/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property array $tags
 * @property string $image
 * @property integer $rating
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
            ['file','file','extensions' => ['png', 'jpg', 'gif', 'jpeg'],'mimeTypes'=>'image/jpeg, image/png, image/gif','maxSize' => 1024*1024*1024],

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
            'rating' => 'Rating',
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


    public function saveFile()
    {

        // название картинки как название заголовка новости
        $imageName = $this->title.'_'.Yii::$app->security->generateRandomString(6);

        // сохраняем файл
        $file = UploadedFile::getInstance($this,'file');

        if($file)
        {
            $ext = end(explode(".", $file->name));
            $file->saveAs('uploads/' . $imageName . '.' . $ext);

            // меняем размер изображения
            $this->resizeImage($imageName . '.' . $ext);

            // сохраняем название файла в БД
            $this->image =  $imageName . '.' . $ext;
        }

    }


    public function resizeImage($fullImageName)
    {

        // меняем размер изображения
        $imagine = new Imagine();

        if ($imagine->open('uploads/' . $fullImageName)
            ->thumbnail(new Box(1000, 960), ImageInterface::THUMBNAIL_INSET)
            ->save('uploads/' . $fullImageName)){
            return 'uploads/' . $fullImageName;
        }

        return false;

    }

    public static function isVoting(){

        //$this->id;

        // todo

        return false;
    }


}
