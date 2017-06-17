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
    static public $textUA = 'абвгдежзийклмнопрстуфхцчшщьєюяіїґ';
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
    
    static function getWord($text, $limit=5) {
        if (str_word_count($text, 0, Check::$textUA) > $limit) {
            $words = str_word_count($text, 2, Check::$textUA);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]-1) . '...';
        }
        return $text;
    }
    
    public function getFirstWord($text=false, $limit=5)
    {
        if ($text === false) {
            $text = $this->doc;
        }
        return Check::getWord($text);
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
