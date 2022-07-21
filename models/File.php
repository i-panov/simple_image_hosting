<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Честно говоря я сам не знаю зачем тут нужна таблица файлов (требовалась по заданию).
 * Проще было просто проверять какие файлы есть в папке и дату создания брать из метаинформации файла.
 * Хотя конечно если бы было нужно что-то еще хранить то она бы все равно понадобилась...
 *
 * @property string $name
 * @property int $created_at
 */
class File extends ActiveRecord
{
    public static function tableName() {
        return '{{%files}}';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules() {
        return [
            [['name', 'created_at'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
            'created_at' => 'Время создания',
        ];
    }
}
