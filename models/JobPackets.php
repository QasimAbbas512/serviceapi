<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_packets".
 *
 * @property int $ID
 * @property string $PacketName
 * @property string $Description
 * @property int $PostsStatus
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 * @property string $FromDate
 * @property string $ToDate
 *
 * @property JobCallResponses[] $jobCallResponses
 * @property JobCallResponses[] $jobCallResponses0
 * @property JobPacketDtl[] $jobPacketDtls
 */
class JobPackets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_packets';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('contacts_data');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PacketName', 'Description', 'PostsStatus', 'EnteredOn', 'EnteredBy', 'BranchID', 'FromDate', 'ToDate'], 'required'],
            [['PostsStatus', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn', 'FromDate', 'ToDate'], 'safe'],
            [['PacketName'], 'string', 'max' => 30],
            [['Description'], 'string', 'max' => 255],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PacketName' => 'Packet Name',
            'Description' => 'Description',
            'PostsStatus' => 'Posts Status',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'BranchID' => 'Branch ID',
            'FromDate' => 'From Date',
            'ToDate' => 'To Date',
        ];
    }

    /**
     * Gets query for [[JobCallResponses]].
     *
     * @return \yii\db\ActiveQuery|JobCallResponsesQuery
     */
    public function getJobCallResponses()
    {
        return $this->hasMany(JobCallResponses::className(), ['JobPacketID' => 'ID']);
    }

    /**
     * Gets query for [[JobCallResponses0]].
     *
     * @return \yii\db\ActiveQuery|JobCallResponsesQuery
     */
    public function getJobCallResponses0()
    {
        return $this->hasMany(JobCallResponses::className(), ['JobPacketID' => 'ID']);
    }

    /**
     * Gets query for [[JobPacketDtls]].
     *
     * @return \yii\db\ActiveQuery|JobPacketDtlQuery
     */
    public function getJobPacketDtls()
    {
        return $this->hasMany(JobPacketDtl::className(), ['PacketID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return JobPacketsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobPacketsQuery(get_called_class());
    }
}
