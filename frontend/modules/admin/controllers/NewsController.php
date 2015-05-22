<?php

namespace frontend\modules\admin\controllers;



use frontend\modules\admin\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;


/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends DashboardController
{


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find(),
            'pagination' => [
                'pageSize' => 3,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
        ]);

        return $this->render('index',
            [
                'dataProvider'=>$dataProvider
            ]
        );
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) )  {


            // название картинки как название заголовка новости
            $imageName = $model->title;


            // сохраняем файл
            $model->file = UploadedFile::getInstance($model,'file');

            $model->file->saveAs('uploads/' . $imageName . '.' . $model->file->extension);


            // меняем размер изображения
            $imagine = new Imagine();

            $imagine->open('uploads/' . $imageName . '.' . $model->file->extension)
                ->thumbnail(new Box(1280, 960), ImageInterface::THUMBNAIL_INSET)
                ->save('uploads/' . $imageName . '.' . $model->file->extension);


            // сохраняем название файла в БД
            $model->image = 'uploads/' . $imageName . '.' . $model->file->extension;

            $model->save();


            return $this->redirect('index');

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) )  {

            // название картинки как название заголовка новости
            $imageName = $model->title;

            // сохраняем файл
            $model->file = UploadedFile::getInstance($model,'file');

            $model->file->saveAs('uploads/' . $imageName . '.' . $model->file->extension);


            // меняем размер изображения
            $imagine = new Imagine();

            $imagine->open('uploads/' . $imageName . '.' . $model->file->extension)
                ->thumbnail(new Box(1100, 960), ImageInterface::THUMBNAIL_INSET)
                ->save('uploads/' . $imageName . '.' . $model->file->extension);

            // сохраняем название файла в БД
            $model->image = 'uploads/' . $imageName . '.' . $model->file->extension;

            $model->save();


            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
