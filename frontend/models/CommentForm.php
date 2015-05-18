<?php
/**
 * Created by PhpStorm.
 * User: kos
 * Date: 30.04.2015
 * Time: 20:50
 */

namespace frontend\models;


use yii\base\Model;

class CommentForm extends Model{

    public $author;
    public $text;

    public $captcha;

    public function rules()
    {
        return [
            [['author', 'text'], 'required'],
            ['captcha', 'required'],
            ['captcha', 'captcha'],
        ];
    }

}