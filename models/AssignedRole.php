<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assigned_role".
 *
 * @property int $ID
 * @property int $DepartmentID
 * @property int $EmployeeID
 * @property int $RoleID
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string|null $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property User $enteredBy
 * @property CompanyBranches $branch
 * @property User $deletedBy
 * @property ParticulerTypes $role
 * @property TeamMembers[] $teamMembers
 */
class AssignedRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assigned_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DepartmentID', 'EmployeeID', 'RoleID', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['DepartmentID', 'EmployeeID', 'RoleID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['DeletedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['DeletedBy' => 'id']],
            [['RoleID'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['RoleID' => 'ID']],
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
            'EmployeeID' => 'Employee ID',
            'RoleID' => 'Role ID',
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
     * Gets query for [[EnteredBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getEnteredBy()
    {
        return $this->hasOne(User::className(), ['id' => 'EnteredBy']);
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
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getRole()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'RoleID']);
    }

    /**
     * Gets query for [[TeamMembers]].
     *
     * @return \yii\db\ActiveQuery|TeamMembersQuery
     */
    public function getTeamMembers()
    {
        return $this->hasMany(TeamMembers::className(), ['ReportingToRoleID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return AssignedRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssignedRoleQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
