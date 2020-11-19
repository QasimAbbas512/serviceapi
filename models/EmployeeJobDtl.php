<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_job_dtl".
 *
 * @property int $ID
 * @property int $EmployeeID
 * @property int $DepartmentID
 * @property int $DesignationID
 * @property string $IssuanceDate
 * @property string $IssuanceEndDate
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property Departments $department
 * @property Designations $designation
 * @property Employees $employee
 */
class EmployeeJobDtl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_job_dtl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeeID', 'DepartmentID', 'DesignationID', 'IssuanceDate', 'IssuanceEndDate', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['EmployeeID', 'DepartmentID', 'DesignationID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['IssuanceDate', 'IssuanceEndDate', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['DepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['DepartmentID' => 'ID']],
            [['DesignationID'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['DesignationID' => 'ID']],
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
            'DepartmentID' => 'Department ID',
            'DesignationID' => 'Designation ID',
            'IssuanceDate' => 'Issuance Date',
            'IssuanceEndDate' => 'Issuance End Date',
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
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery|DepartmentsQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Departments::className(), ['ID' => 'DepartmentID']);
    }

    /**
     * Gets query for [[Designation]].
     *
     * @return \yii\db\ActiveQuery|DesignationsQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(Designations::className(), ['ID' => 'DesignationID']);
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
     * @return EmployeeJobDtlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeJobDtlQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
