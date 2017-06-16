<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "check".
 *
 * @property int $id
 * @property string $doc
 * @property string $body
 * @property int $created
 */
class Check extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doc', 'body', 'created'], 'required'],
            [['doc', 'body'], 'string'],
            [['created'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc' => 'Документ',
            'body' => 'Підготовлений текст',
            'created' => 'Створено',
        ];
    }
}
