<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $ID
 * @property int $DepartmentID
 * @property string $TeamName
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property User $enteredBy
 * @property User $enteredBy0
 * @property CompanyBranches $branch
 * @property CompanyBranches $branch0
 * @property User $deletedBy
 * @property User $deletedBy0
 * @property Departments $department
 * @property TeamMembers[] $teamMembers
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DepartmentID', 'TeamName', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['DepartmentID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['TeamName'], 'string', 'max' => 15],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['DeletedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['DeletedBy' => 'id']],
            [['DeletedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['DeletedBy' => 'id']],
            [['DepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['DepartmentID' => 'ID']],
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
            'TeamName' => 'Team Name',
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
     * Gets query for [[EnteredBy0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getEnteredBy0()
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
     * Gets query for [[Branch0]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getBranch0()
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
     * Gets query for [[DeletedBy0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getDeletedBy0()
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
     * Gets query for [[TeamMembers]].
     *
     * @return \yii\db\ActiveQuery|TeamMembersQuery
     */
    public function getTeamMembers()
    {
        return $this->hasMany(TeamMembers::className(), ['TeamID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return TQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
