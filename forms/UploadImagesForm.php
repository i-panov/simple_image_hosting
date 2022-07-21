<?php

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadImagesForm extends Model
{
    /** @var UploadedFile[] */
    public $images;

    public function rules()
    {
        return [
            ['images', 'required'],
            ['images', 'image',
                'skipOnEmpty' => false,
                'maxFiles' => 5,
                'checkExtensionByMimeType' => false,
                'extensions' => 'png, jpg, jpeg',
                //'mimeTypes' => 'image/*',
            ],
        ];
    }
}
