<?php

namespace frontend\modules\admin\models;


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