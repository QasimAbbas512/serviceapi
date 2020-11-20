<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_investment".
 *
 * @property int $ID
 * @property int $ClientID
 * @property int $ProjectID
 * @property string $ContractDate
 * @property string $ContractExpiryDate
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property ClientsInfo $client
 * @property Projects $project
 */
class ClientInvestment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_investment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ClientID', 'ProjectID', 'ContractDate', 'ContractExpiryDate', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['ClientID', 'ProjectID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['ContractDate', 'ContractExpiryDate', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['ClientID'], 'exist', 'skipOnError' => true, 'targetClass' => ClientsInfo::className(), 'targetAttribute' => ['ClientID' => 'ID']],
            [['ProjectID'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['ProjectID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ClientID' => 'Client ID',
            'ProjectID' => 'Project ID',
            'ContractDate' => 'Contract Date',
            'ContractExpiryDate' => 'Contract Expiry Date',
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
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery|ClientsInfoQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientsInfo::className(), ['ID' => 'ClientID']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery|ProjectsQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['ID' => 'ProjectID']);
    }

    /**
     * {@inheritdoc}
     * @return ClientInvestmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientInvestmentQuery(get_called_class());
    }
}
