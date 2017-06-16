<?php

namespace app\models;

use Yii;
use app\models\Plagiat;

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
     * @_engUaWold
     */
    static function _engUaWold($body) {
        return $body;
    }
    
    /**
     * @_engUaWolds
     */
    static function _engUaWolds($words) {
        $asoc = [
            // e | i | a | y | p | o | x | c
            'e' => 'е',      'i' => 'і',
            'a' => 'а',      'y' => 'у',
            'p' => 'р',      'o' => 'о',
            'x' => 'х',      'c' => 'с',
            // B | T | K | H | M
            'b' => 'в',      't' => 'т',
            'k' => 'к',      'h' => 'н',
            'm' => 'м',
        ];
        $keys = array_keys($asoc);
        $values = array_values($asoc);
        foreach($words as $k => $word) {
            if(preg_match('/[a-z]/is', $word) && preg_match('/[а-яієїґ]/isu', $word)) {
                $words[$k] = str_replace($keys, $values, $word);
            }
        }
        return $words;
    }
    
    /**
     * @_dropBackWords
     */
    static function _dropBackWords($text) {
        $pattern = '/(e|ю|а|и|і|о|й|у|я|ою|ой|ий|ом|ів|ій|ня|их|ах|еї|ею|єю|ою|ая|ові|еві|ем|єм|нь|ок)\s/iu';
        $text = preg_replace($pattern, ' ', "$text ");
        return $text;
    }
    
    /**
     * @_doc2body
     */
    static function _doc2body($doc) {
        // Нижній регіст + UTF-8
        $body = mb_strtolower($doc, 'UTF-8');

        // Видалити апострофи
        $body = preg_replace('/\'/', '', $body);

        // Видалити службові символи
        $pattern = 'a-zа-яієїґ0-9';
        $body = mb_ereg_replace("[^$pattern]", ' ', $body);

        // Видалити закінчення у слів
        $body = Theses::_dropBackWords($body);

        // Видалити слова менше 4-х символів
        $body = preg_replace('/\s+/', ' ', $body);
        $body = preg_replace('/\s/', '  ', $body);
        $body = mb_ereg_replace('\s['.$pattern.']{1,3}\s', '', " $body ");
        $body = preg_replace('/\s+/', ' ', trim($body));

        // Залишити тільки унікальні слова
        $body = explode(' ', $body);
        $body = array_unique($body);

        // Перевірити на англо-україно вмісні слова
        $body = Theses::_engUaWolds($body);
        
        $body = join(' ', $body);
        
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
    
    public function canCheck()
    {
        return strlen($this->body) > 15;
    }
    
    public function deletePlagiat() {
        Plagiat::deleteAll('id1 = :id1 OR id2 = :id2', [
            ':id1' => $this->id, 
            ':id2' => $this->id
        ]);
    }
    public function plagiat() {
        $plagiat = Plagiat::find()
            ->orWhere(['id1' => $this->id])
            ->orWhere(['id2' => $this->id])
            ->all();
        return $plagiat; 
    }
    public function checkWithGTid($force=false)
    {
        $all = Theses::find()
            ->where('id > :this_id', [':this_id' => $this->id])
            ->all();
        $_all = [];
        foreach ($all as $key => $these) {
            if ($these->canCheck()) {
                $res = Plagiat::getByThese($this->id, $these->id);
                if (!$res || $force) {
                    $update = $res? true: false;
                    $res = Theses::check($this->body, $these->body);
                    $res = Plagiat::saveRes($this->id, $these->id, $res, $update);
                }
                $_all[] = $res->info();
            }
        }
        return $_all;
    }
    
    public function checkThese($force=false) {
        $_all = [];
        if ($this->canCheck()) {
            $all = Theses::find()
                ->where('id != :id', [':id' => $this->id])
                ->all();
            foreach ($all as $key => $these) {
                if ($these->canCheck()) {
                    $res = Plagiat::getByThese($this->id, $these->id);
                    if (!$res || $force) {
                        $update = $res? true: false;
                        $res = Theses::check($this->body, $these->body);
                        $res = Plagiat::saveRes($this->id, $these->id, $res, $update);
                    }
                    $_all[] = $res;
                }
            }
        }
        return $_all;
    }
    
    static function check($body1, $body2) {
        $mess = '';
        if (strlen($body1) > 200000 || strlen($body2) > 200000) {
            $mess = "Довжина обох або одного з текстів перевищує допустиму (200 000)!";
            Yii::$app->session->setFlash('warning', $mess);
            return 0;
        }
        $res = [];
        
        for ($i=1; $i<5; $i++) {
            $first_shingles = array_unique(Theses::getShingle($body1, $i));
            $second_shingles = array_unique(Theses::getShingle($body2, $i));
            if(count($first_shingles) < $i-1 || count($second_shingles) < $i-1) {
                $mess = 'Кількість слів в тексті меньше чим довжина шинглу!';
                Yii::$app->session->setFlash('warning', $mess);
                continue;
            }
            $intersect = array_intersect($first_shingles, $second_shingles);
            $merge = array_unique(array_merge($first_shingles, $second_shingles));
            $diff = (count($intersect)/count($merge));// /0.01;
            $res["per$i"] = $diff;
        }
        
        return $res;
    }
    
    static function getShingle($text, $n=3) {
        $shingles = [];
        $elements = explode(' ' , $text);
        $len = count($elements)-$n+1;
        for ($i=0; $i<$len; $i++) {
            $shingle = '';
            for ($j=0; $j<$n; $j++) {
                $shingle .= mb_strtolower(trim($elements[$i+$j]), 'UTF-8')." ";
            }
            if(strlen(trim($shingle))) {
                $shingles[$i] = trim($shingle, ' -');
            }
        }
        return $shingles;
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
