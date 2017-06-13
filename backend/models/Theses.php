<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theses".
 *
 * @property int $id
 * @property string $subject
 * @property string $author
 * @property string $curator
 * @property string $doc
 */
class Theses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'theses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'author', 'curator', 'doc'], 'required'],
            [['doc'], 'string'],
            [['subject', 'author', 'curator'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'author' => 'Author',
            'curator' => 'Curator',
            'doc' => 'Doc',
        ];
    }
}
