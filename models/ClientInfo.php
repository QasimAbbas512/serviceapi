<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_info".
 *
 * @property int $ID
 * @property int $SalutationID
 * @property string $FirstName
 * @property string $LastName
 * @property string $Cnic
 * @property string $CellNo
 * @property string $EmailAddress
 * @property string $CellNo2
 * @property string $Address
 * @property string $UserName
 * @property string $Password
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property int|null $DeletedBy
 * @property string|null $DeletedOn
 * @property int $BranchID
 *
 * @property ClientInvestment[] $clientInvestments
 * @property ParticulerTypes $salutation
 */
class ClientInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SalutationID', 'FirstName', 'LastName', 'Cnic', 'CellNo', 'EmailAddress', 'CellNo2', 'Address', 'UserName', 'Password', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['SalutationID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['FirstName', 'LastName', 'CellNo', 'CellNo2', 'UserName'], 'string', 'max' => 15],
            [['Cnic'], 'string', 'max' => 35],
            [['EmailAddress'], 'string', 'max' => 25],
            [['Address'], 'string', 'max' => 40],
            [['Password'], 'string', 'max' => 20],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['SalutationID'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['SalutationID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'SalutationID' => 'Salutation ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'Cnic' => 'Cnic',
            'CellNo' => 'Cell No',
            'EmailAddress' => 'Email Address',
            'CellNo2' => 'Cell No2',
            'Address' => 'Address',
            'UserName' => 'User Name',
            'Password' => 'Password',
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
     * Gets query for [[ClientInvestments]].
     *
     * @return \yii\db\ActiveQuery|ClientInvestmentQuery
     */
    public function getClientInvestments()
    {
        return $this->hasMany(ClientInvestment::className(), ['ClientID' => 'ID']);
    }

    /**
     * Gets query for [[Salutation]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getSalutation()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'SalutationID']);
    }

    /**
     * {@inheritdoc}
     * @return ClientInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientInfoQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
