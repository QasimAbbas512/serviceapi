<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cities;

/**
 * CitiesSearch represents the model behind the search form of `app\models\Cities`.
 */
class CitiesSearch extends Cities
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CityID', 'Entered_By', 'ProvinceID', 'CountryID', 'DeletedBy', 'District_Id'], 'integer'],
            [['Name', 'Acronym', 'Entered_On', 'Synchronize', 'Code', 'Active', 'IsDeleted', 'DeletedOn', 'Session_Id'], 'safe'],
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
        $query = Cities::find();

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
            'CityID' => $this->CityID,
            'Entered_By' => $this->Entered_By,
            'Entered_On' => $this->Entered_On,
            'ProvinceID' => $this->ProvinceID,
            'CountryID' => $this->CountryID,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'District_Id' => $this->District_Id,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Acronym', $this->Acronym])
            ->andFilterWhere(['like', 'Synchronize', $this->Synchronize])
            ->andFilterWhere(['like', 'Code', $this->Code])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted])
            ->andFilterWhere(['like', 'Session_Id', $this->Session_Id]);

        return $dataProvider;
    }
}
