<?php

namespace frontend\models;

use linslin\yii2\curl;
use phpQuery;
use Yii;

/**
 * This is the model class for table "players_info".
 *
 * @property integer $id
 * @property integer $old_id
 * @property string $name
 * @property string $transliteration
 * @property string $birthday
 * @property string $nationality
 * @property integer $team_id
 */
class PlayersInfo extends \yii\db\ActiveRecord
{

    public $arrOldId = array();
    public $arrName = array();
    public $arrTransliteration = array();
    public $arrDate = array();
    public $arrNationality = array();
    public $teamId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'players_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_id', 'team_id'], 'integer'],
            [['birthday'], 'safe'],
            [['name', 'transliteration', 'nationality'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'old_id' => 'Old ID',
            'name' => 'Name',
            'transliteration' => 'Transliteration',
            'birthday' => 'Birthday',
            'nationality' => 'Nationality',
            'team_id' => 'Team ID',
        ];
    }

    public function generatePlayersInfo()
    {

        $url = 'http://www.transfermarkt.co.uk/chelsea-fc/startseite/verein/631';

        $content = $this->curl($url);

        $doc = phpQuery::newDocument($content);


        // находим old_id
        $doc->find(".items .hauptlink .hide-for-small")->each(function($item) use ($doc)
        {
            $oldId = pq($item)->find('a')->attr('id');
            $this->arrOldId[] = $oldId;
        });


        // находим имя
        $doc->find(".items .hauptlink .hide-for-small")->each(function($item) use ($doc)
        {
            $name = pq($item)->find('a')->text();
            $this->arrName[] = $name;
        });


        // делаем транслит
        $cnt = count($this->arrOldId);  // длина массивов

        $this->arrTransliteration = $this->translit($cnt);


        // находим дату рождения
        $doc->find(".items .zentriert:contains(',')")->each(function($item) use ($doc)
        {
            $date = pq($item)->text();
            $pos = stripos($date, '(');
            $date =substr($date, 0 , $pos);

            $date = strtotime($date);       // секунды
            $date = date('Y-m-d', $date);

            $this->arrDate[] = $date;

        });

        // находим гражданство
        $doc->find(".items .zentriert:has(img)")->each(function($item) use ($doc)
        {
            $nationality1 = pq($item)->find('img:first-child ')->attr('title');
            $nationality2 = pq($item)->find('img:last-child')->attr('title');
            if($nationality1 == $nationality2)
            {
                $nationality = $nationality1;
            }
            else
                $nationality = $nationality1 . ',' . $nationality2;

            $this->arrNationality[] = $nationality;

        });

        // находим id команды
        $pos = strrpos($url, '/');
        $this->team_id = substr($url, $pos + 1);


        for($i = 0;$i < $cnt;$i++)
        {
            $pInfo = new PlayersInfo();

            $pInfo->old_id = $this->arrOldId[$i];
            $pInfo->name = $this->arrName[$i];
            $pInfo->transliteration = $this->arrTransliteration[$i];
            $pInfo->birthday = $this->arrDate[$i];
            $pInfo->nationality = $this->arrNationality[$i];
            $pInfo->team_id = $this->team_id;

            if (!$pInfo::findOne(['old_id' => $pInfo->old_id])) {
                $pInfo->save();
            }
        }

    }

    public function curl($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

        $headers = array
        (
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
            'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
            'Accept-Encoding: deflate',
            'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
        );

        // добавляем заголовков к нашему запросу. Чтоб смахивало на настоящих
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);


        // Функции для обработки установливаемых кук
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");

        // Убрать или оставить вывод данных в браузер
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // выполняем запрос curl
        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }


    public function translit($cnt)
    {
        $arr[] = array();

        $translit = array(

            'а' => 'a',   'б' => 'b',   'в' => 'v',

            'г' => 'g',   'д' => 'd',   'е' => 'e',

            'ё' => 'yo',  'ж' => 'zh', 'з' => 'z',

            'и' => 'i',   'й' => 'j',   'к' => 'k',

            'л' => 'l',   'м' => 'm',   'н' => 'n',

            'о' => 'o',   'п' => 'p',   'р' => 'r',

            'с' => 's',   'т' => 't',   'у' => 'u',

            'ф' => 'f',   'х' => 'x',   'ц' => 'c',

            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',

            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'\'',

            'э' => 'e\'', 'ю' => 'yu',  'я' => 'ya',

            'x' => 'h',


            'А' => 'A',   'Б' => 'B',   'В' => 'V',

            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',

            'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',

            'И' => 'I',   'Й' => 'J',   'К' => 'K',

            'Л' => 'L',   'М' => 'M',   'Н' => 'N',

            'О' => 'O',   'П' => 'P',   'Р' => 'R',

            'С' => 'S',   'Т' => 'T',   'У' => 'U',

            'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',

            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',

            'Ь' => '\'',  'Ы' => 'Y\'',   'Ъ' => '\'\'',

            'Э' => 'E\'',   'Ю' => 'YU',  'Я' => 'YA',

        );

        for($i = 0;$i < $cnt;$i++)
        {
            $arr[$i]= strtr($this->arrName[$i], array_flip($translit));
        }

        return $arr;
    }


    public function getPlayersInfo()
    {
        $players = PlayersInfo::find()->all();

        return $players;
    }


}
