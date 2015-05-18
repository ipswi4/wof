<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

    'modules' => [
        'admin' => [
            'class' => 'frontend\modules\admin\AdminModule',
        ],
    ],

    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enableStrictParsing' => false,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'routeParam'=>'url',
            'rules' => [
                'gii' => 'gii',
                'debug' => 'debug',


                // league
                'league/<id:\d+>' => 'league/view',


                // club
                'club/<id:\d+>' => 'club/view',


                // season
                'season/<id:\d+>' => 'season/view',
                'season/<id:\d+>/calendar' => 'season/calendar',
                'season/<id:\d+>/generate' => 'season/generate',


                // news
                'news/<id:\d+>' => 'news/view',
                'news' => 'news/list',


                // admin
                'admin'=>'admin/default/index',


                // captcha
                'admin/site/captcha'=>'site/captcha',


                '<controller:\w+>/page/<page:\d+>' => '<controller>/index',
                '<controller:\w+>' => '<controller>/index',


                '<cmd:\w+>/<action:\w+>'=>'<cmd>/<action>',
                '<cmd:\w+>/<action:\w+>/<state:\w+>'=>'<cmd>/<action>/<state>',
                '<cmd:\w+>/<action:\w+>/<state:\w+>/<sid:\w+>'=>'<cmd>/<action>/<state>/<sid>',
                ]
            ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
