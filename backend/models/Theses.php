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
     * @doc2body
     */
    static function _doc2body($doc) {
        $body = mb_strtolower($doc, 'UTF-8');
        $body = preg_replace('/\'/', '', $body);
        $pattern = 'a-zа-яієїґ0-9';
        $body = mb_ereg_replace("[^$pattern]", ' ', $body);
        $body = preg_replace('/\s+/', ' ', trim($body));
        $body = preg_replace('/\s/', '  ', trim($body));
        $body = mb_ereg_replace('\s['.$pattern.']{1,3}\s', ' ', " $body ");
        $body = preg_replace('/\s+/', ' ', trim($body));
        $body = explode(' ', $body);
        $body = array_unique($body);
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
                /*var_dump('$res');
                var_dump($res);*/
                if (!$res || $force) {
                    $res = Theses::check($this->body, $these->body);
                    $res = Plagiat::saveRes($this->id, $these->id, $res);
                    // var_dump($res);
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
                    /*var_dump($res);
                    var_dump($force);*/
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
