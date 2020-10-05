<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_packet_dtl".
 *
 * @property int $ID
 * @property int $PacketID
 * @property int $ContactID
 * @property string $ContactNumber
 * @property string $ContactNotes
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property ContactNumberList $contact
 * @property JobPackets $packet
 */
class JobPacketDtl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_packet_dtl';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('contacts_data_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PacketID', 'ContactID', 'ContactNumber', 'ContactNotes', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['PacketID', 'ContactID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['ContactNumber'], 'string', 'max' => 20],
            [['ContactNotes'], 'string', 'max' => 255],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['ContactID'], 'exist', 'skipOnError' => true, 'targetClass' => ContactNumberList::className(), 'targetAttribute' => ['ContactID' => 'ID']],
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
            'PacketID' => 'Packet ID',
            'ContactID' => 'Contact ID',
            'ContactNumber' => 'Contact Number',
            'ContactNotes' => 'Contact Notes',
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
     * @return JobPacketDtlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobPacketDtlQuery(get_called_class());
    }
}
