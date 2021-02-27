<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "call_appointment".
 *
 * @property int $ID
 * @property int $JobID
 * @property int $ContactID
 * @property int|null $CallRecordID
 * @property string $AppointmentTime
 * @property int $EmployeeID
 * @property string $FetchStatus
 * @property string $Active
 * @property string|null $EnteredOn
 *
 * @property JobPacketDtl $job
 * @property ContactNumberList $contact
 * @property JobCallResponses $callRecord
 */
class CallAppointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_appointment';
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
            [['JobID', 'ContactID', 'AppointmentTime', 'EmployeeID'], 'required'],
            [['JobID', 'ContactID', 'CallRecordID', 'EmployeeID'], 'integer'],
            [['EnteredOn'], 'safe'],
            [['AppointmentTime'], 'string', 'max' => 20],
            [['FetchStatus', 'Active'], 'string', 'max' => 1],
            [['JobID'], 'exist', 'skipOnError' => true, 'targetClass' => JobPacketDtl::className(), 'targetAttribute' => ['JobID' => 'ID']],
            [['ContactID'], 'exist', 'skipOnError' => true, 'targetClass' => ContactNumberList::className(), 'targetAttribute' => ['ContactID' => 'ID']],
            [['CallRecordID'], 'exist', 'skipOnError' => true, 'targetClass' => JobCallResponses::className(), 'targetAttribute' => ['CallRecordID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'JobID' => 'Job ID',
            'ContactID' => 'Contact ID',
            'CallRecordID' => 'Call Record ID',
            'AppointmentTime' => 'Appointment Time',
            'EmployeeID' => 'Employee ID',
            'FetchStatus' => 'Fetch Status',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
        ];
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(JobPacketDtl::className(), ['ID' => 'JobID']);
    }

    /**
     * Gets query for [[Contact]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(ContactNumberList::className(), ['ID' => 'ContactID']);
    }

    /**
     * Gets query for [[CallRecord]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCallRecord()
    {
        return $this->hasOne(JobCallResponses::className(), ['ID' => 'CallRecordID']);
    }
}
