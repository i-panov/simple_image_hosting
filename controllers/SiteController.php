<?php

namespace app\controllers;

use app\forms\UploadImagesForm;
use app\models\File;
use dastanaron\translit\Translit;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $uploadedImageNames = $this->uploadedImageNames();

        if ($uploadedImageNames) {
            $uploadedImageNames = array_filter($uploadedImageNames, function($name) {
                return is_file($this->storageDirectory() . "/$name");
            });

            if ($uploadedImageNames) {
                $files = File::find()->where(['name' => $uploadedImageNames])->all();
            }
        }

        if (empty($files)) {
            $files = [];
        }

        return $this->render('index', ['dataProvider' => new ArrayDataProvider(['allModels' => $files])]);
    }

    public function actionUploadImages()
    {
        $model = new UploadImagesForm();
        $model->images = UploadedFile::getInstancesByName('images');

        if (!$model->validate()) {
            return $this->asJson(['error' => current($model->firstErrors)]);
        } else {
            $translit = new Translit();
            $names = [];

            foreach ($model->images as $image) {
                $name = $translit->translit($image->baseName, true, 'ru-en') . uniqid('_') . '.' . $image->extension;
                $image->saveAs($this->storageDirectory() . "/$name");

                $file = new File();
                $file->name = $name;
                $file->save(false);
                $names[] = $file->name;
            }

            $this->uploadedImageNames($names);
            Yii::$app->session->setFlash('success', 'Загружено');
        }

        return $this->redirect(['site/index']);
    }

    private function storageDirectory()
    {
        $path = Yii::getAlias('@webroot/storage');

        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }

        return $path;
    }

    private function uploadedImageNames($add = null)
    {
        $key = 'uploaded_image_names';
        $current = (array)Yii::$app->session->get($key, []);

        if (!$add || !is_array($add)) {
            return $current;
        }

        $next = array_unique($current + $add);
        Yii::$app->session->set($key, $next);
        return $next;
    }
}
