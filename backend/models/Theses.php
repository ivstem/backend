<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theses".
 *
 * @property int $id
 * @property string $npp
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
     * @doc2body
     */
    static function _doc2body($doc) {
        $body = mb_strtolower($doc, 'UTF-8');
        $pattern = '[^A-Za-zА-Яа-яіІєЄїЇґҐ0-9]';
        $body = mb_ereg_replace($pattern, ' ', $body);
        $body = preg_replace('/\s+/', ' ', trim($body));
        return $body;
    }
    
    /**
     * @doc2body
     */
    public function doc2body()
    {
        $body = Theses::_doc2body($this->doc);
        if ($body) {
            $this->body = $body;
        }
        return $body;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'author', 'curator', 'doc', 'group'], 'required'],
            [['doc'], 'string'],
            [['subject', 'author', 'curator', 'npp', 'group'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'npp' => 'Інвент. номер',
            'subject' => 'Тема',
            'group' => 'Група',
            'author' => 'Автор',
            'curator' => 'Куратор',
            'doc' => 'Текст',
            'body' => 'Body',
        ];
    }
}
