<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact_number_list".
 *
 * @property int $ID
 * @property string $ContactName
 * @property int $NumberType
 * @property string $ContactNumber
 * @property string $ServiceProvider
 * @property string $ContactAddress
 * @property string $ContactCityID
 * @property string $Area
 * @property string $ContactNotes
 * @property int $ContactStatus
 * @property int $RegionType
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 * @property string $Record_Type
 *
 * @property JobCallResponses[] $jobCallResponses
 * @property JobPacketDtl[] $jobPacketDtls
 */
class ContactNumberList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_number_list';
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
            [['ContactName', 'NumberType', 'ContactNumber', 'ServiceProvider', 'ContactAddress', 'ContactCityID', 'Area', 'ContactNotes', 'ContactStatus', 'RegionType', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['NumberType', 'ContactStatus', 'RegionType', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['ContactNotes'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['ContactName', 'Area'], 'string', 'max' => 30],
            [['ContactNumber', 'ServiceProvider', 'ContactCityID'], 'string', 'max' => 20],
            [['ContactAddress'], 'string', 'max' => 255],
            [['Active', 'IsDeleted', 'Record_Type'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ContactName' => 'Contact Name',
            'NumberType' => 'Number Type',
            'ContactNumber' => 'Contact Number',
            'ServiceProvider' => 'Service Provider',
            'ContactAddress' => 'Contact Address',
            'ContactCityID' => 'Contact City ID',
            'Area' => 'Area',
            'ContactNotes' => 'Contact Notes',
            'ContactStatus' => 'Contact Status',
            'RegionType' => 'Region Type',
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
     * Gets query for [[JobCallResponses]].
     *
     * @return \yii\db\ActiveQuery|JobCallResponsesQuery
     */
    public function getJobCallResponses()
    {
        return $this->hasMany(JobCallResponses::className(), ['ContactID' => 'ID']);
    }

    /**
     * Gets query for [[JobPacketDtls]].
     *
     * @return \yii\db\ActiveQuery|JobPacketDtlQuery
     */
    public function getJobPacketDtls()
    {
        return $this->hasMany(JobPacketDtl::className(), ['ContactID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return ContactNumberListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactNumberListQuery(get_called_class());
    }
}
