<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_call_responses".
 *
 * @property int $ID
 * @property int $PacketDtlID
 * @property int $JobPacketID
 * @property int $ContactID
 * @property int $ResponseID
 * @property string $CallFilePath
 * @property string $AudioNote
 * @property string $OtherNote
 * @property int $UserID
 * @property string $MacInfo
 * @property string $UUID
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property ContactNumberList $contact
 * @property JobPackets $jobPacket
 * @property JobPackets $jobPacket0
 */
class JobCallResponses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_call_responses';
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
            [['PacketDtlID', 'JobPacketID', 'ContactID', 'ResponseID', 'UserID', 'MacInfo', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['PacketDtlID', 'JobPacketID', 'ContactID', 'ResponseID', 'UserID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['OtherNote'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['CallFilePath'], 'string', 'max' => 100],
            [['AudioNote'], 'string', 'max' => 150],
            [['MacInfo'], 'string', 'max' => 30],
            [['UUID'], 'string', 'max' => 255],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['ContactID'], 'exist', 'skipOnError' => true, 'targetClass' => ContactNumberList::className(), 'targetAttribute' => ['ContactID' => 'ID']],
            [['JobPacketID'], 'exist', 'skipOnError' => true, 'targetClass' => JobPackets::className(), 'targetAttribute' => ['JobPacketID' => 'ID']],
            [['JobPacketID'], 'exist', 'skipOnError' => true, 'targetClass' => JobPackets::className(), 'targetAttribute' => ['JobPacketID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PacketDtlID' => 'Packet Dtl ID',
            'JobPacketID' => 'Job Packet ID',
            'ContactID' => 'Contact ID',
            'ResponseID' => 'Response ID',
            'CallFilePath' => 'Call File Path',
            'AudioNote' => 'Audio Note',
            'OtherNote' => 'Other Note',
            'UserID' => 'User ID',
            'MacInfo' => 'Mac Info',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[Contact]].
     *
     * @return \yii\db\ActiveQuery|ContactNumberListQuery
     */
    public function getContact()
    {
        return $this->hasOne(ContactNumberList::className(), ['ID' => 'ContactID']);
    }

    /**
     * Gets query for [[JobPacket]].
     *
     * @return \yii\db\ActiveQuery|JobPacketsQuery
     */
    public function getJobPacket()
    {
        return $this->hasOne(JobPackets::className(), ['ID' => 'JobPacketID']);
    }

    /**
     * Gets query for [[JobPacket0]].
     *
     * @return \yii\db\ActiveQuery|JobPacketsQuery
     */
    public function getJobPacket0()
    {
        return $this->hasOne(JobPackets::className(), ['ID' => 'JobPacketID']);
    }

    /**
     * {@inheritdoc}
     * @return JobCallResponsesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobCallResponsesQuery(get_called_class());
    }
}
