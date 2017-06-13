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
