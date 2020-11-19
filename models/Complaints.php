<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaints".
 *
 * @property int $ID
 * @property string $Heading
 * @property int $Category
 * @property string $Description
 * @property int $RequestedBy
 * @property int $RequestedFor
 * @property string $CompletionDate
 * @property string $ComplaintDate
 * @property string $Status
 * @property string $CompletedDate
 * @property int $CompletedBy
 * @property int $ByDepartmentID
 * @property int $ForDepartmentID
 * @property string $Active
 * @property int $EnteredBy
 * @property string $EnteredOn
 * @property string $IsDeleted
 * @property int|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property CompanyBranches $branch
 * @property Employees $requestedFor
 * @property Departments $byDepartment
 * @property Departments $forDepartment
 * @property Employees $requestedBy
 * @property Employees $completedBy
 * @property ParticulerTypes $category
 */
class Complaints extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complaints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Heading', 'Category', 'Description', 'RequestedBy', 'RequestedFor', 'CompletionDate', 'ComplaintDate', 'Status', 'CompletedDate', 'CompletedBy', 'ByDepartmentID', 'ForDepartmentID', 'EnteredBy', 'EnteredOn', 'BranchID'], 'required'],
            [['Heading', 'Description'], 'string'],
            [['Category', 'RequestedBy', 'RequestedFor', 'CompletedBy', 'ByDepartmentID', 'ForDepartmentID', 'EnteredBy', 'DeletedOn', 'DeletedBy', 'BranchID'], 'integer'],
            [['CompletionDate', 'ComplaintDate', 'CompletedDate', 'EnteredOn'], 'safe'],
            [['Status'], 'string', 'max' => 10],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['RequestedFor'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['RequestedFor' => 'ID']],
            [['ByDepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['ByDepartmentID' => 'ID']],
            [['ForDepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['ForDepartmentID' => 'ID']],
            [['RequestedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['RequestedBy' => 'ID']],
            [['CompletedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['CompletedBy' => 'ID']],
            [['Category'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['Category' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Heading' => 'Heading',
            'Category' => 'Category',
            'Description' => 'Description',
            'RequestedBy' => 'Requested By',
            'RequestedFor' => 'Requested For',
            'CompletionDate' => 'Completion Date',
            'ComplaintDate' => 'Complaint Date',
            'Status' => 'Status',
            'CompletedDate' => 'Completed Date',
            'CompletedBy' => 'Completed By',
            'ByDepartmentID' => 'By Department ID',
            'ForDepartmentID' => 'For Department ID',
            'Active' => 'Active',
            'EnteredBy' => 'Entered By',
            'EnteredOn' => 'Entered On',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getBranch()
    {
        return $this->hasOne(CompanyBranches::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * Gets query for [[RequestedFor]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getRequestedFor()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'RequestedFor']);
    }

    /**
     * Gets query for [[ByDepartment]].
     *
     * @return \yii\db\ActiveQuery|DepartmentsQuery
     */
    public function getByDepartment()
    {
        return $this->hasOne(Departments::className(), ['ID' => 'ByDepartmentID']);
    }

    /**
     * Gets query for [[ForDepartment]].
     *
     * @return \yii\db\ActiveQuery|DepartmentsQuery
     */
    public function getForDepartment()
    {
        return $this->hasOne(Departments::className(), ['ID' => 'ForDepartmentID']);
    }

    /**
     * Gets query for [[RequestedBy]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getRequestedBy()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'RequestedBy']);
    }

    /**
     * Gets query for [[CompletedBy]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getCompletedBy()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'CompletedBy']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'Category']);
    }

    /**
     * {@inheritdoc}
     * @return ComplaintsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComplaintsQuery(get_called_class());
    }
}
