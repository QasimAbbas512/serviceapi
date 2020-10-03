<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CompanyBranches;

/**
 * CompanyBranchesSearch represents the model behind the search form of `app\models\CompanyBranches`.
 */
class CompanyBranchesSearch extends CompanyBranches
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BranchID', 'CompanyID', 'BranchType', 'CityID', 'ProvinceID', 'CountryID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['BranchName', 'BranchAddress', 'BranchEmail', 'LandLineNo', 'GeoLocation', 'Active', 'ActiveDate', 'ExpiryDate', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = CompanyBranches::find();

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
            'BranchID' => $this->BranchID,
            'CompanyID' => $this->CompanyID,
            'BranchType' => $this->BranchType,
            'CityID' => $this->CityID,
            'ProvinceID' => $this->ProvinceID,
            'CountryID' => $this->CountryID,
            'ActiveDate' => $this->ActiveDate,
            'ExpiryDate' => $this->ExpiryDate,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'BranchName', $this->BranchName])
            ->andFilterWhere(['like', 'BranchAddress', $this->BranchAddress])
            ->andFilterWhere(['like', 'BranchEmail', $this->BranchEmail])
            ->andFilterWhere(['like', 'LandLineNo', $this->LandLineNo])
            ->andFilterWhere(['like', 'GeoLocation', $this->GeoLocation])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
