<?php
namespace app\models;
use Yii;
use CommonFunctions;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $CompanyID
 * @property int $BranchID
 * @property int|null $EmpID
 * @property string $UserName
 * @property string $PasswordKey
 * @property string $SetRole
 * @property string $UserType Web user, Machine user, Mobile user, API user, crone user
 * @property string $Active
 * @property string $EnteredOn
 * @property int|null $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property AppResponse[] $appResponses
 * @property AppResponse[] $appResponses0
 * @property AppResponseDtl[] $appResponseDtls
 * @property AppResponseDtl[] $appResponseDtls0
 * @property BankList[] $bankLists
 * @property BankList[] $bankLists0
 * @property Company[] $companies
 * @property Company[] $companies0
 * @property CompanyBranches[] $companyBranches
 * @property CompanyBranches[] $companyBranches0
 * @property Departments[] $departments
 * @property Departments[] $departments0
 * @property Designations[] $designations
 * @property Designations[] $designations0
 * @property Employees[] $employees
 * @property Employees[] $employees0
 * @property ParticulerTypes[] $particulerTypes
 * @property ParticulerTypes[] $particulerTypes0
 * @property Particulers[] $particulers
 * @property Particulers[] $particulers0
 * @property CompanyBranches $company
 * @property CompanyBranches $branch
 * @property Employees $emp
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::UserInfo($this->id,1);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyID', 'BranchID', 'UserName', 'PasswordKey', 'SetRole', 'EnteredOn'], 'required'],
            [['CompanyID', 'BranchID', 'EmpID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['UserName', 'PasswordKey'], 'string', 'max' => 150],
            [['SetRole'], 'string', 'max' => 50],
            [['UserType'], 'string', 'max' => 11],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['UserName'], 'unique'],
            [['CompanyID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['CompanyID' => 'CompanyID']],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['EmpID'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['EmpID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'CompanyID' => 'Company ID',
            'BranchID' => 'Branch ID',
            'EmpID' => 'Emp ID',
            'UserName' => 'User Name',
            'PasswordKey' => 'Password Key',
            'SetRole' => 'Set Role',
            'UserType' => 'User Type',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
        ];
    }

    /**
     * Gets query for [[AppResponses]].
     *
     * @return \yii\db\ActiveQuery|AppResponseQuery
     */
    public function getAppResponses()
    {
        return $this->hasMany(AppResponse::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[AppResponseDtls]].
     *
     * @return \yii\db\ActiveQuery|AppResponseDtlQuery
     */
    public function getAppResponseDtls()
    {
        return $this->hasMany(AppResponseDtl::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[BankLists]].
     *
     * @return \yii\db\ActiveQuery|BankListQuery
     */
    public function getBankLists()
    {
        return $this->hasMany(BankList::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[Companies]].
     *
     * @return \yii\db\ActiveQuery|CompanyQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[CompanyBranches]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getCompanyBranches()
    {
        return $this->hasMany(CompanyBranches::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery|DepartmentsQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[Designations]].
     *
     * @return \yii\db\ActiveQuery|DesignationsQuery
     */
    public function getDesignations()
    {
        return $this->hasMany(Designations::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[ParticulerTypes]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getParticulerTypes()
    {
        return $this->hasMany(ParticulerTypes::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[Particulers]].
     *
     * @return \yii\db\ActiveQuery|ParticulersQuery
     */
    public function getParticulers()
    {
        return $this->hasMany(Particulers::className(), ['EnteredBy' => 'id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getCompany()
    {
        return $this->hasOne(CompanyBranches::className(), ['CompanyID' => 'CompanyID']);
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

    /*Following function will be used for login and get value for session*/
    public static function findByUsername($username)
    {
        return static::findOne(['UserName' => $username, 'Active' => 'Y']);
    }

    public function validatePassword($password)
    {
        return $this->PasswordKey === $password;
    }

    public static function findIdentity($id)
    {
       // return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    /*Following function will be used for login and get value for session*/

    /**
     * Gets query for [[Emp]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'EmpID']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
