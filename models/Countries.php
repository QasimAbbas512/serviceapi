<?php

namespace app\models;

use Yii;
use CommonFunctions;

/**
 * This is the model class for table "countries".
 *
 * @property int $CountryID
 * @property string|null $Name
 * @property string|null $Acronym
 * @property string|null $Code
 * @property string|null $Currency
 * @property string $Active
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property string|null $Session_id
 *
 * @property Cities[] $cities
 * @property CompanyBranches[] $companyBranches
 * @property Provinces[] $provinces
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */

    public function beforeSave($insert) {


        if ($insert) {

              CommonFunctions::selectCountries(1);
        }else{//update event
            //delete cache keys
            CommonFunctions::selectCountries(1);
            CommonFunctions::selectCountryInfo($this->CountryID,1);
            CommonFunctions::printCountryName($this->CountryID,1);
        }

        return parent::beforeSave($insert);

    }

    public function rules()
    {
        return [
            [['DeletedOn'], 'safe'],
            [['DeletedBy'], 'integer'],
            [['Name'], 'string', 'max' => 45],
            [['Acronym'], 'string', 'max' => 8],
            [['Code'], 'string', 'max' => 5],
            [['Currency'], 'string', 'max' => 10],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['Session_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CountryID' => 'Country ID',
            'Name' => 'Name',
            'Acronym' => 'Acronym',
            'Code' => 'Code',
            'Currency' => 'Currency',
            'Active' => 'Active',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'Session_id' => 'Session ID',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCities()
    {
        return $this->hasMany(Cities::className(), ['CountryID' => 'CountryID']);
    }

    /**
     * Gets query for [[CompanyBranches]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getCompanyBranches()
    {
        return $this->hasMany(CompanyBranches::className(), ['CountryID' => 'CountryID']);
    }

    /**
     * Gets query for [[Provinces]].
     *
     * @return \yii\db\ActiveQuery|ProvincesQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Provinces::className(), ['CountryID' => 'CountryID']);
    }

    /**
     * {@inheritdoc}
     * @return CountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }
}
