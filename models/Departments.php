<?php

namespace app\models;

use Yii;
use CommonFunctions;

/**
 * This is the model class for table "departments".
 *
 * @property int $ID
 * @property string $DepartmentName
 * @property string|null $Description
 * @property string $Active
 * @property int $BranchID
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property CompanyBranches $branch
 * @property Users $enteredBy
 * @property Employees[] $employees
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    public function beforeSave($insert) {

        if ($insert) {

        }else{//update event
            //delete cache keys
            CommonFunctions::selectDepartmentInfo($this->ID,$this->BranchID,1);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectDepartmentInfo($this->ID,$this->BranchID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DepartmentName', 'BranchID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['Description'], 'string'],
            [['BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['DepartmentName'], 'string', 'max' => 50],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DepartmentName' => 'Department Name',
            'Description' => 'Description',
            'Active' => 'Active',
            'BranchID' => 'Branch ID',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
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
     * Gets query for [[EnteredBy]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getEnteredBy()
    {
        return $this->hasOne(User::className(), ['id' => 'EnteredBy']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['DepartmentID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return DepartmentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentsQuery(get_called_class());
    }
}
