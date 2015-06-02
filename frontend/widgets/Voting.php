<?php

namespace frontend\widgets;


use Yii;
use yii\base\Widget;


class Voting extends Widget
{

    public $vote;

    public function run()
    {

        return $this->render('voting/Voting', [
            'model' => $this->vote,
        ]);

    }

}