<?php
namespace frontend\controllers;

use common\models\Club;
use common\models\User;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

class ManagerController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        if (!\Yii::$app->user->identity->club) $this->redirect(['manager/select-clubs']);


        return $this->render('index');
    }

    public function actionSelectClubs()
    {
        $clubs = Club::getAllClubNotCoach();

        return $this->render('select',['clubs'=>$clubs]);
    }

    public function actionAdd($club){

        $clubModel = Club::findOne($club);
        /** @var Club $clubModel */
        if (!is_null($clubModel->user)) throw new BadRequestHttpException("Club is joined");

        if (!\Yii::$app->user->identity->club){
            /** @var User $user */
            $user = \Yii::$app->user->identity;
            $user->club_id = $club;
            if ($user->save()) $this->redirect(['club/view','id'=>$club]);
        }


    }

}
