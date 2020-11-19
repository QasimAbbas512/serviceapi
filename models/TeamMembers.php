<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team_members".
 *
 * @property int $ID
 * @property int $DepartmentID
 * @property int $TeamID
 * @property int $EmployeeID
 * @property int $RoleID
 * @property int $ReportingToDesignationID
 * @property int|null $ReportingToEmpID
 * @property string $Active
 * @property int $EnteredBy
 * @property string $EnteredOn
 * @property int|null $DeletedBy
 * @property string|null $DeletedOn
 * @property int $BranchID
 * @property string|null $IsDeleted
 *
 * @property Employees $employee
 * @property User $enteredBy
 * @property Team $team
 * @property CompanyBranches $branch
 * @property User $deletedBy
 * @property Departments $department
 * @property Designations $reportingToDesignation
 * @property ParticulerTypes $role
 * @property Employees $reportingToEmp
 */
class TeamMembers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DepartmentID', 'TeamID', 'EmployeeID', 'RoleID', 'ReportingToDesignationID', 'EnteredBy', 'EnteredOn', 'BranchID'], 'required'],
            [['DepartmentID', 'TeamID', 'EmployeeID', 'RoleID', 'ReportingToDesignationID', 'ReportingToEmpID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['EmployeeID'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['EmployeeID' => 'ID']],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['TeamID'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['TeamID' => 'ID']],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['DeletedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['DeletedBy' => 'id']],
            [['DepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['DepartmentID' => 'ID']],
            [['ReportingToDesignationID'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['ReportingToDesignationID' => 'ID']],
            [['RoleID'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['RoleID' => 'ID']],
            [['ReportingToEmpID'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['ReportingToEmpID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DepartmentID' => 'Department ID',
            'TeamID' => 'Team ID',
            'EmployeeID' => 'Employee ID',
            'RoleID' => 'Role ID',
            'ReportingToDesignationID' => 'Reporting To Designation ID',
            'ReportingToEmpID' => 'Reporting To Emp ID',
            'Active' => 'Active',
            'EnteredBy' => 'Entered By',
            'EnteredOn' => 'Entered On',
            'DeletedBy' => 'Deleted By',
            'DeletedOn' => 'Deleted On',
            'BranchID' => 'Branch ID',
            'IsDeleted' => 'Is Deleted',
        ];
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
     * Gets query for [[EnteredBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getEnteredBy()
    {
        return $this->hasOne(User::className(), ['id' => 'EnteredBy']);
    }

    /**
     * Gets query for [[Team]].
     *
     * @return \yii\db\ActiveQuery|TQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['ID' => 'TeamID']);
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
     * Gets query for [[DeletedBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'DeletedBy']);
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
     * Gets query for [[ReportingToDesignation]].
     *
     * @return \yii\db\ActiveQuery|DesignationsQuery
     */
    public function getReportingToDesignation()
    {
        return $this->hasOne(Designations::className(), ['ID' => 'ReportingToDesignationID']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getRole()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'RoleID']);
    }

    /**
     * Gets query for [[ReportingToEmp]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getReportingToEmp()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'ReportingToEmpID']);
    }

    /**
     * {@inheritdoc}
     * @return TeamMembersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeamMembersQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
