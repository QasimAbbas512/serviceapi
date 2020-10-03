<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppResponse;

/**
 * AppResponseSearch represents the model behind the search form of `app\models\AppResponse`.
 */
class AppResponseSearch extends AppResponse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'Active', 'BranchID', 'EnteredOn', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['ResponceHeading', 'InputType', 'AppUsed', 'AppUserType', 'EventName', 'Description', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = AppResponse::find();

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
            'Active' => $this->Active,
            'BranchID' => $this->BranchID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'ResponceHeading', $this->ResponceHeading])
            ->andFilterWhere(['like', 'InputType', $this->InputType])
            ->andFilterWhere(['like', 'AppUsed', $this->AppUsed])
            ->andFilterWhere(['like', 'AppUserType', $this->AppUserType])
            ->andFilterWhere(['like', 'EventName', $this->EventName])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
