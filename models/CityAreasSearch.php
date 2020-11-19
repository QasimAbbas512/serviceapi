<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CityAreas;

/**
 * CityAreasSearch represents the model behind the search form of `app\models\CityAreas`.
 */
class CityAreasSearch extends CityAreas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'CityId', 'ProvinceId', 'CountryId'], 'integer'],
            [['AreaName', 'GeoLocation'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CityAreas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'CityId' => $this->CityId,
            'ProvinceId' => $this->ProvinceId,
            'CountryId' => $this->CountryId,
        ]);

        $query->andFilterWhere(['like', 'AreaName', $this->AreaName])
            ->andFilterWhere(['like', 'GeoLocation', $this->GeoLocation]);

        return $dataProvider;
    }
}
