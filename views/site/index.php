<?php

use app\models\File;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \yii\data\DataProviderInterface $dataProvider */

$this->title = 'Image Hosting';

echo FileInput::widget([
    'name' => 'images',
    'language' => 'ru',
    'options' => ['multiple' => true, 'accept' => 'image/*'],
    'pluginOptions' => [
        'uploadUrl' => Url::to(['site/upload-images']),
        'maxFileCount' => 5,
        'previewFileType' => 'image',
    ]
]);

echo Html::beginTag('div', ['class' => 'mt-5']);

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'created_at:datetime',
        [
            'label' => 'Изображение',
            'format' => 'raw',
            'content' => function(File $file) {
                $id = Html::encode('image_' . $file->name);
                $path = '/storage/' . $file->name;
                $img = Html::img($path, ['width' => 100, 'height' => 100]);
                $modal = Html::tag('div', Html::img($path), ['id' => $id, 'class' => 'modal']);
                return Html::a($img, "#$id", ['rel' => 'modal:open']) . $modal;
            },
        ],
    ],
]);

echo Html::endTag('div');
