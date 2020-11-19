<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_allocated_asset".
 *
 * @property int $ID
 * @property int $EmployeeID
 * @property int $AssetID
 * @property string $AllocationDate
 * @property string $FilePath
 * @property string $Completion
 * @property string $Description
 * @property int $IssueTypeID
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property CompanyAsset $asset
 * @property ParticulerTypes $issueType
 * @property Employees $employee
 */
class EmployeeAllocatedAsset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_allocated_asset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeeID', 'AssetID', 'AllocationDate', 'FilePath', 'CompletionDate', 'Description', 'IssueTypeID', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['EmployeeID', 'AssetID', 'IssueTypeID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['AllocationDate', 'CompletionDate', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['Description'], 'string'],
            [['FilePath'], 'string', 'max' => 100],
           
            [['AssetID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyAsset::className(), 'targetAttribute' => ['AssetID' => 'ID']],
            [['IssueTypeID'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['IssueTypeID' => 'ID']],
            [['EmployeeID'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['EmployeeID' => 'ID']],
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
            'AssetID' => 'Asset ID',
            'AllocationDate' => 'Allocation Date',
            'FilePath' => 'File Path',
            'CompletionDate' => 'CompletionDate',
            'Description' => 'Description',
            'IssueTypeID' => 'Issue Type ID',
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
     * Gets query for [[Asset]].
     *
     * @return \yii\db\ActiveQuery|CompanyAssetQuery
     */
    public function getAsset()
    {
        return $this->hasOne(CompanyAsset::className(), ['ID' => 'AssetID']);
    }

    /**
     * Gets query for [[IssueType]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getIssueType()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'IssueTypeID']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'EmployeeID']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeAllocatedAssetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeAllocatedAssetQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
