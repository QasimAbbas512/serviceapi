<?php

namespace app\models;

use Yii;
use CommonFunctions;

/**
 * This is the model class for table "employees".
 *
 * @property int $ID
 * @property int|null $SalutationID
 * @property string|null $FirstName
 * @property string|null $MiddleName
 * @property string|null $LastName
 * @property string|null $FullName
 * @property string|null $GuardianRelation Son of (S/O), Daughter of (D/O), Wife of (W/O)
 * @property string|null $GuardianName
 * @property string|null $DateOfBirth
 * @property string|null $Gender
 * @property string|null $CellNo
 * @property string|null $CNIC
 * @property string|null $ImageName
 * @property int|null $MaritalStatus
 * @property int|null $BloodGroup
 * @property string|null $Email
 * @property string|null $Address
 * @property string|null $AttMachineNo user for mapping with attendance machine data
 * @property int $DesignationID
 * @property int|null $DepartmentID
 * @property string|null $JoiningDate
 * @property string|null $ExpireDate
 * @property string|null $NTN_No
 * @property string|null $AccountNo
 * @property string|null $AccountTitle
 * @property int|null $BankID
 * @property string|null $Active
 * @property string|null $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property CompanyBranches $branch
 * @property Users $enteredBy
 * @property ParticulerTypes $salutation
 * @property Departments $department
 * @property Designations $designation
 * @property User[] $users
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }


    public function beforeSave($insert) {

        if ($insert) {
            $full_name = CommonFunctions::setEmpFullName($_POST['Employees']['SalutationID'],$_POST['Employees']['FirstName'],$_POST['Employees']['LastName']);
            $this->FullName = $full_name;

            $this->DateOfBirth = date('Y-m-d', strtotime($_POST['Employees']['DateOfBirth']));
            $this->JoiningDate = date('Y-m-d', strtotime($_POST['Employees']['JoiningDate']));
            $this->ExpireDate = date('Y-m-d', strtotime($_POST['Employees']['ExpireDate']));
        }else{//update event

            $full_name = CommonFunctions::setEmpFullName($_POST['Employees']['SalutationID'],$_POST['Employees']['FirstName'],$_POST['Employees']['LastName']);
            $this->FullName = $full_name;

            $this->DateOfBirth = date('Y-m-d', strtotime($_POST['Employees']['DateOfBirth']));
            $this->JoiningDate = date('Y-m-d', strtotime($_POST['Employees']['JoiningDate']));
            $this->ExpireDate = date('Y-m-d', strtotime($_POST['Employees']['ExpireDate']));
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectEmployeeInfo($this->ID,$this->BranchID,1);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SalutationID', 'MaritalStatus', 'BloodGroup', 'DesignationID', 'DepartmentID', 'BankID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['DateOfBirth', 'JoiningDate', 'ExpireDate', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['DesignationID', 'EnteredBy', 'BranchID'], 'required'],
            [['FirstName', 'GuardianName'], 'string', 'max' => 45],
            [['MiddleName', 'LastName', 'CellNo', 'AttMachineNo'], 'string', 'max' => 20],
            [['FullName'], 'string', 'max' => 85],
            [['GuardianRelation'], 'string', 'max' => 4],
            [['Gender', 'IsDeleted'], 'string', 'max' => 1],
            [['CNIC', 'NTN_No'], 'string', 'max' => 30],
            [['ImageName'], 'string', 'max' => 150],
            [['Email', 'Address'], 'string', 'max' => 255],
            [['AccountNo', 'AccountTitle'], 'string', 'max' => 50],
            [['Active'], 'string', 'max' => 3],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['SalutationID'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['SalutationID' => 'ID']],
            [['DepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['DepartmentID' => 'ID']],
            [['DesignationID'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['DesignationID' => 'ID']],
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
            'MiddleName' => 'Middle Name',
            'LastName' => 'Last Name',
            'FullName' => 'Full Name',
            'GuardianRelation' => 'Guardian Relation',
            'GuardianName' => 'Guardian Name',
            'DateOfBirth' => 'Date Of Birth',
            'Gender' => 'Gender',
            'CellNo' => 'Cell No',
            'CNIC' => 'Cnic',
            'ImageName' => 'Image Name',
            'MaritalStatus' => 'Marital Status',
            'BloodGroup' => 'Blood Group',
            'Email' => 'Email',
            'Address' => 'Address',
            'AttMachineNo' => 'Att Machine No',
            'DesignationID' => 'Designation ID',
            'DepartmentID' => 'Department ID',
            'JoiningDate' => 'Joining Date',
            'ExpireDate' => 'Expire Date',
            'NTN_No' => 'Ntn No',
            'AccountNo' => 'Account No',
            'AccountTitle' => 'Account Title',
            'BankID' => 'Bank ID',
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
     * Gets query for [[Salutation]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getSalutation()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'SalutationID']);
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
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasMany(User::className(), ['EmpID' => 'ID']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     * @return EmployeesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeesQuery(get_called_class());
    }
}
