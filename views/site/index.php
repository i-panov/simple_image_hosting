<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \yii\data\DataProviderInterface $dataProvider */

$this->title = 'Image Hosting';

echo \kartik\file\FileInput::widget([
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
]);

echo Html::endTag('div');
