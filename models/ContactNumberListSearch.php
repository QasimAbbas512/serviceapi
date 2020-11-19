<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContactNumberList;

/**
 * ContactNumberListSearch represents the model behind the search form of `app\models\ContactNumberList`.
 */
class ContactNumberListSearch extends ContactNumberList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'NumberType', 'ContactStatus', 'RegionType', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['ContactName', 'ContactNumber', 'ServiceProvider', 'ContactAddress', 'ContactCityID', 'Area', 'ContactNotes', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = ContactNumberList::find();

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
            'NumberType' => $this->NumberType,
            'ContactStatus' => $this->ContactStatus,
            'RegionType' => $this->RegionType,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'ContactName', $this->ContactName])
            ->andFilterWhere(['like', 'ContactNumber', $this->ContactNumber])
            ->andFilterWhere(['like', 'ServiceProvider', $this->ServiceProvider])
            ->andFilterWhere(['like', 'ContactAddress', $this->ContactAddress])
            ->andFilterWhere(['like', 'ContactCityID', $this->ContactCityID])
            ->andFilterWhere(['like', 'Area', $this->Area])
            ->andFilterWhere(['like', 'ContactNotes', $this->ContactNotes])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
