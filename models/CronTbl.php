<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cron_tbl".
 *
 * @property int $ID
 * @property int $SetNum
 * @property string $Status
 * @property string $LastTime
 */
class CronTbl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cron_tbl';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('machine_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SetNum', 'LastTime'], 'required'],
            [['SetNum'], 'integer'],
            [['LastTime'], 'safe'],
            [['Status'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'SetNum' => 'Set Num',
            'Status' => 'Status',
            'LastTime' => 'Last Time',
        ];
    }
}
