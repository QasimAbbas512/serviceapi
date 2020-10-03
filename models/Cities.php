<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $CityID
 * @property string|null $Name
 * @property string|null $Acronym
 * @property int|null $Entered_By
 * @property string|null $Entered_On
 * @property string|null $Synchronize
 * @property int|null $ProvinceID
 * @property int|null $CountryID
 * @property string|null $Code
 * @property string $Active
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property string|null $Session_Id
 * @property int|null $District_Id
 *
 * @property Countries $country
 * @property Provinces $province
 * @property CompanyBranches[] $companyBranches
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    public function beforeSave($insert) {

        if ($insert) {
            CommonFunctions::selectCityInfo($this->CityID,1);
        }else{//update event
            //delete cache keys
            CommonFunctions::selectCityInfo($this->CityID,1);
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Entered_By', 'ProvinceID', 'CountryID', 'DeletedBy', 'District_Id'], 'integer'],
            [['Entered_On', 'DeletedOn'], 'safe'],
            [['Name'], 'string', 'max' => 45],
            [['Acronym'], 'string', 'max' => 8],
            [['Synchronize'], 'string', 'max' => 3],
            [['Code'], 'string', 'max' => 5],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['Session_Id'], 'string', 'max' => 50],
            [['CountryID'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['CountryID' => 'CountryID']],
            [['ProvinceID'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['ProvinceID' => 'ProvinceId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CityID' => 'City ID',
            'Name' => 'Name',
            'Acronym' => 'Acronym',
            'Entered_By' => 'Entered By',
            'Entered_On' => 'Entered On',
            'Synchronize' => 'Synchronize',
            'ProvinceID' => 'Province ID',
            'CountryID' => 'Country ID',
            'Code' => 'Code',
            'Active' => 'Active',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'Session_Id' => 'Session ID',
            'District_Id' => 'District ID',
        ];
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
     * Gets query for [[CompanyBranches]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getCompanyBranches()
    {
        return $this->hasMany(CompanyBranches::className(), ['CityID' => 'CityID']);
    }

    /**
     * {@inheritdoc}
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
}
