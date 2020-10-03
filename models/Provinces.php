<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property int $ProvinceId
 * @property string|null $Name
 * @property string|null $Acronym
 * @property int $CountryID
 * @property string $Active
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property string|null $Synchronize
 * @property string|null $Session_id
 *
 * @property Cities[] $cities
 * @property CompanyBranches[] $companyBranches
 * @property Countries $country
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provinces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountryID'], 'required'],
            [['CountryID', 'DeletedBy'], 'integer'],
            [['DeletedOn'], 'safe'],
            [['Name'], 'string', 'max' => 45],
            [['Acronym'], 'string', 'max' => 8],
            [['Active', 'IsDeleted', 'Synchronize'], 'string', 'max' => 1],
            [['Session_id'], 'string', 'max' => 50],
            [['CountryID'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['CountryID' => 'CountryID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProvinceId' => 'Province ID',
            'Name' => 'Name',
            'Acronym' => 'Acronym',
            'CountryID' => 'Country ID',
            'Active' => 'Active',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'Synchronize' => 'Synchronize',
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
        return $this->hasMany(Cities::className(), ['ProvinceID' => 'ProvinceId']);
    }

    /**
     * Gets query for [[CompanyBranches]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getCompanyBranches()
    {
        return $this->hasMany(CompanyBranches::className(), ['ProvinceID' => 'ProvinceId']);
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
     * {@inheritdoc}
     * @return ProvincesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProvincesQuery(get_called_class());
    }
}
