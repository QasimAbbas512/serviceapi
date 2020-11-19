<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_job_packet_dtl".
 *
 * @property int $ID
 * @property int $EmployeeID
 * @property int $PacketID
 * @property int|null $PacketCount
 * @property int|null $CalledNo
 * @property int|null $Pendings
 * @property int $Status
 * @property string|null $AssignedOn
 * @property int|null $AssignedBy
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property int|null $DeletedBy
 * @property string|null $DeletedOn
 * @property int $BranchID
 *
 * @property JobPackets $packet
 */
class EmployeeJobPacketDtl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_job_packet_dtl';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('contact_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeeID', 'PacketID', 'Status', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['EmployeeID', 'PacketID', 'PacketCount', 'CalledNo', 'Pendings', 'Status', 'AssignedBy', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['AssignedOn', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['PacketID'], 'exist', 'skipOnError' => true, 'targetClass' => JobPackets::className(), 'targetAttribute' => ['PacketID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'EmployeeID' => 'Employee ID',
            'PacketID' => 'Packet ID',
            'PacketCount' => 'Packet Count',
            'CalledNo' => 'Called No',
            'Pendings' => 'Pendings',
            'Status' => 'Status',
            'AssignedOn' => 'Assigned On',
            'AssignedBy' => 'Assigned By',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedBy' => 'Deleted By',
            'DeletedOn' => 'Deleted On',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[Packet]].
     *
     * @return \yii\db\ActiveQuery|JobPacketsQuery
     */
    public function getPacket()
    {
        return $this->hasOne(JobPackets::className(), ['ID' => 'PacketID']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeJobPacketDtlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeJobPacketDtlQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
