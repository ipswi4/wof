<?php

namespace frontend\modules\admin;

class AdminModule extends \yii\base\Module
{

    const ROLE_USER = 1;

    const ROLE_ADMIN = 10;

    public $controllerNamespace = 'frontend\modules\admin\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
