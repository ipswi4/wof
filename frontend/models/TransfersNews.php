<?php

namespace frontend\models;

use Yii;
use phpQuery;

/**
 * This is the model class for table "transfers_news".
 *
 * @property integer $id
 * @property string $site
 * @property integer $old_id
 * @property string $create_date
 * @property string $content
 */
class TransfersNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfers_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_id'], 'integer'],
            [['create_date'], 'safe'],
            [['content'], 'string'],
            [['site'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site' => 'Site',
            'old_id' => 'Old ID',
            'create_date' => 'Create Date',
            'content' => 'Content',
        ];
    }

    public function generateTransferNews()
    {
        $content = file_get_contents('http://www.goal.com/en/live-update/1054/transfer-window-live/10');

        $doc = phpQuery::newDocument($content);

        // находим все блоки с новостями
        $doc->find("#live-update-messages .live-update-row")->each(function($item) use ($doc)
        {

            $tNews = new TransfersNews();

            // добавляем название сайта в БД
            $tNews->site = 'http://www.goal.com';

            // находим id новости
            $id = (int)(pq($item)->find('div[data-template="id"]')->text());

            if (!$id) return;

            $tNews->old_id = $id;

            // определяем дату
            $moment = pq($item)->find('div[data-template="moment"]')->text();
            //2015-07-17 14:08:00

            $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $moment);
            $tNews->create_date = $dt->format(\DateTime::W3C);


            // находим новость
            $text = (pq($item)->find('div[data-template="content"]')->html());

            $tNews->content = $text;



            // находим заголовок новости
            /*
            $title = (pq($item)->find('strong')->html());
            $title = strip_tags($title);
            $tNews->title = $title;
            */

            // находим картинку новости
            /*
            $firstChar = strripos($text, 'src="http://static.goal.com/');   // последнее вхождение
            $image = substr($text, $firstChar + 5);

            $lastChar = strpos($image, '"');        // первое вхождение
            $image = substr($image, 0, $lastChar);

            $tNews->image = $image;
            */

            // находим контент
            /*
            $firstChar = strpos($text, '<br><br>');
            $content = substr($text, $firstChar);
            $content = strip_tags($content);

            $firstChar = strripos($content, '.');
            $content = substr($content, 0, $firstChar + 1);

            $tNews->content = $content;
            */

            // проверяем есть ли запись с таким old_id в таблице
            if (!$tNews::findOne(['old_id' => $id])) {
                $tNews->save();
            }

        });
    }

    public function getTransfersNews()
    {
        $news = TransfersNews::find()->all();

        return $news;
    }

}
