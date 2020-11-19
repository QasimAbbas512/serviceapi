<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Provinces;

/**
 * ProvincesSearch represents the model behind the search form of `app\models\Provinces`.
 */
class ProvincesSearch extends Provinces
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProvinceId', 'CountryID', 'DeletedBy'], 'integer'],
            [['Name', 'Acronym', 'Active', 'IsDeleted', 'DeletedOn', 'Synchronize', 'Session_id'], 'safe'],
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
        $query = Provinces::find();

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
            'ProvinceId' => $this->ProvinceId,
            'CountryID' => $this->CountryID,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Acronym', $this->Acronym])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted])
            ->andFilterWhere(['like', 'Synchronize', $this->Synchronize])
            ->andFilterWhere(['like', 'Session_id', $this->Session_id]);

        return $dataProvider;
    }
}
