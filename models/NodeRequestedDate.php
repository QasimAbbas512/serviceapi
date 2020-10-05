<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "node_requested_date".
 *
 * @property int $ID
 * @property string $DataPacket
 * @property string $RequestDestination
 * @property string $ReceivedOn
 * @property int $Status
 * @property int $Picked
 * @property int $Completed
 * @property int $Tried
 * @property string|null $PickedTime
 * @property string|null $CompletedTime
 */
class NodeRequestedDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'node_requested_date';
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
            [['DataPacket', 'RequestDestination', 'ReceivedOn'], 'required'],
            [['DataPacket'], 'string'],
            [['ReceivedOn', 'PickedTime', 'CompletedTime'], 'safe'],
            [['Status', 'Picked', 'Completed', 'Tried'], 'integer'],
            [['RequestDestination'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DataPacket' => 'Data Packet',
            'RequestDestination' => 'Request Destination',
            'ReceivedOn' => 'Received On',
            'Status' => 'Status',
            'Picked' => 'Picked',
            'Completed' => 'Completed',
            'Tried' => 'Tried',
            'PickedTime' => 'Picked Time',
            'CompletedTime' => 'Completed Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NodeRequestedDateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NodeRequestedDateQuery(get_called_class());
    }
}
