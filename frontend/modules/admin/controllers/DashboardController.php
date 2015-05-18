<?php
/**
 * Created by PhpStorm.
 * User: kos
 * Date: 18.05.2015
 * Time: 20:21
 */

namespace frontend\modules\admin\controllers;


use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class DashboardController extends Controller{


    public function beforeAction($action){
        if (parent::beforeAction($action)) {

            var_dump(\Yii::$app->user->can('user'));exit;

            if (!\Yii::$app->user->can('dashboad')) {
                //\Yii::$app->response->redirect('/site/login');
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }

}