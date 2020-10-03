<?php

namespace app\models;

use Yii;
use CommonFunctions;

/**
 * This is the model class for table "company_branches".
 *
 * @property int $BranchID
 * @property int $CompanyID
 * @property string|null $BranchName
 * @property string $BranchAddress
 * @property string $BranchEmail
 * @property string|null $LandLineNo land line number will add coma separated
 * @property int $BranchType Master or main office value is 1 all other branches value is 0
 * @property int $CityID
 * @property int $ProvinceID
 * @property int $CountryID
 * @property string|null $GeoLocation add google map link
 * @property string $Active used to set active and inactive branch
 * @property string|null $ActiveDate App start date of a company
 * @property string|null $ExpiryDate this date will allow user to login in valid date.
 * @property string|null $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property AppResponse[] $appResponses
 * @property AppResponseDtl[] $appResponseDtls
 * @property Users $enteredBy
 * @property Company $company
 * @property Countries $country
 * @property Provinces $province
 * @property Cities $city
 * @property Departments[] $departments
 * @property Designations[] $designations
 * @property Employees[] $employees
 * @property User[] $users
 * @property User[] $users0
 */
class CompanyBranches extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_branches';
    }


    public function beforeSave($insert) {

        if ($insert) {
            $this->EnteredBy = Yii::$app->session->get('user_id');
            $this->EnteredOn = date('Y-m-d H:i:s');
        }else{//update event
            //delete cache keys
            $this->EnteredBy = Yii::$app->session->get('user_id');
            $this->EnteredOn = date('Y-m-d H:i:s');
            CommonFunctions::selectCompanyBranchInfo($this->BranchID,1);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectCompanyBranchInfo($this->BranchID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyID', 'BranchAddress', 'BranchEmail', 'BranchType', 'CityID', 'ProvinceID', 'CountryID', 'EnteredBy'], 'required'],
            [['CompanyID', 'BranchType', 'CityID', 'ProvinceID', 'CountryID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['ActiveDate', 'ExpiryDate', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['BranchName'], 'string', 'max' => 30],
            [['BranchAddress'], 'string', 'max' => 150],
            [['BranchEmail', 'LandLineNo'], 'string', 'max' => 50],
            [['GeoLocation'], 'string', 'max' => 250],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['CompanyID'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['CompanyID' => 'CompanyID']],
            [['CountryID'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['CountryID' => 'CountryID']],
            [['ProvinceID'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['ProvinceID' => 'ProvinceId']],
            [['CityID'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['CityID' => 'CityID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BranchID' => 'Branch ID',
            'CompanyID' => 'Company ID',
            'BranchName' => 'Branch Name',
            'BranchAddress' => 'Branch Address',
            'BranchEmail' => 'Branch Email',
            'LandLineNo' => 'Land Line No',
            'BranchType' => 'Branch Type',
            'CityID' => 'City ID',
            'ProvinceID' => 'Province ID',
            'CountryID' => 'Country ID',
            'GeoLocation' => 'Geo Location',
            'Active' => 'Active',
            'ActiveDate' => 'Active Date',
            'ExpiryDate' => 'Expiry Date',
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
        return $this->hasMany(AppResponse::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * Gets query for [[AppResponseDtls]].
     *
     * @return \yii\db\ActiveQuery|AppResponseDtlQuery
     */
    public function getAppResponseDtls()
    {
        return $this->hasMany(AppResponseDtl::className(), ['BranchID' => 'BranchID']);
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
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery|CompanyQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['CompanyID' => 'CompanyID']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery|CountriesQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery|ProvincesQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Provinces::className(), ['ProvinceId' => 'ProvinceID']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['CityID' => 'CityID']);
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery|DepartmentsQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * Gets query for [[Designations]].
     *
     * @return \yii\db\ActiveQuery|DesignationsQuery
     */
    public function getDesignations()
    {
        return $this->hasMany(Designations::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['CompanyID' => 'CompanyID']);
    }

    /**
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * {@inheritdoc}
     * @return CompanyBranchesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyBranchesQuery(get_called_class());
    }
}
