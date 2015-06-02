<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\modules\admin\models\Comment;
use frontend\modules\admin\models\CommentForm;


class CommentList extends Widget
{

    public $news;

    public function run()
    {

        $commentForm = new CommentForm();

        // данные в $model удачно проверены
        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()) {

            $commentModel = new Comment();
            $commentModel->id_news = $this->news->id;
            $commentModel->author = $commentForm->author;
            $commentModel->text = $commentForm->text;

            $commentModel->save();
        }

        return $this->render('comments/CommentList', [
            'model' => $this->news,
            'formModel' => $commentForm,
        ]);

    }

}