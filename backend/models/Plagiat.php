<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plagiat".
 *
 * @property int $id
 * @property int $id1
 * @property int $id2
 * @property double $per1
 * @property double $per2
 * @property double $per3
 * @property double $per4
 */
class Plagiat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plagiat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id1', 'id2', 'per1', 'per2', 'per3', 'per4'], 'required'],
            [['id1', 'id2'], 'integer'],
            [['per1', 'per2', 'per3', 'per4'], 'number'],
        ];
    }
    
    static function _2normalIDs($id1, $id2) {
        if ($id1 > $id2) {
            $buff_id = $id1;
            $id1 = $id2;
            $id2 = $buff_id;
        }
        return [$id1, $id2];
    }
    
    static function getByThese($id1, $id2) {
        $id = Plagiat::_2normalIDs($id1, $id2);
        return Plagiat::find()
            ->where([
                'id1' => $id[0],
                'id2' => $id[1],
            ])
            ->one();
    }
    
    static function saveRes($id1, $id2, $res, $update) {
        if ($update) {
            $plagiat = Plagiat::getByThese($id1, $id2);
            if ($plagiat) {
                $plagiat->per1 = $res['per1'];
                $plagiat->per2 = $res['per2'];
                $plagiat->per3 = $res['per3'];
                $plagiat->per4 = $res['per4'];
            }
        }
        if (!$plagiat) {
            $id = Plagiat::_2normalIDs($id1, $id2);
            $plagiat = new Plagiat([
                'id1' => $id[0],
                'id2' => $id[1],
                'per1' => $res['per1'],
                'per2' => $res['per2'],
                'per3' => $res['per3'],
                'per4' => $res['per4'],
            ]);
        }
        $plagiat->save();
        return $plagiat;
    }

    public function info($level='base') {
        $per = [$this->per1, $this->per2, $this->per3, $this->per4];
        $average = array_sum($per) * .25;
        $res = [
            'average' => $average,
            'percent' => round($average * 100, 2),
            'per_' => $per,
            'per' => [
                round($per[0] * 100, 2),
                round($per[1] * 100, 2),
                round($per[2] * 100, 2),
                round($per[3] * 100, 2),
            ],
        ];
        if ($level == 'full' || $level == 'full+') {
            $res['id1'] = $this->id1;
            $res['id2'] = $this->id2;
            if ($level == 'full+') {
                $res['_id1'] = Theses::findOne($res['id1']);
                $res['_id2'] = Theses::findOne($res['id2']);
            }
        }
        return $res;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id1' => 'Id1',
            'id2' => 'Id2',
            'per1' => 'Per1',
            'per2' => 'Per2',
            'per3' => 'Per3',
            'per4' => 'Per4',
        ];
    }
}
