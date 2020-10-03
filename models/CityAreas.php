<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city_areas".
 *
 * @property int $ID
 * @property string $AreaName
 * @property string|null $GeoLocation
 * @property int $CityId
 * @property int $ProvinceId
 * @property int $CountryId
 */
class CityAreas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city_areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AreaName', 'CityId', 'ProvinceId', 'CountryId'], 'required'],
            [['CityId', 'ProvinceId', 'CountryId'], 'integer'],
            [['AreaName'], 'string', 'max' => 50],
            [['GeoLocation'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'AreaName' => 'Area Name',
            'GeoLocation' => 'Geo Location',
            'CityId' => 'City ID',
            'ProvinceId' => 'Province ID',
            'CountryId' => 'Country ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CityAreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityAreasQuery(get_called_class());
    }
}
