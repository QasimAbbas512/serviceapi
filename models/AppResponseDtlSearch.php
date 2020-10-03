<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppResponseDtl;

/**
 * AppResponseDtlSearch represents the model behind the search form of `app\models\AppResponseDtl`.
 */
class AppResponseDtlSearch extends AppResponseDtl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'ResponseHeadID', 'OptionText', 'OptionValue', 'BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['Description', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = AppResponseDtl::find();

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
            'ResponseHeadID' => $this->ResponseHeadID,
            'OptionText' => $this->OptionText,
            'OptionValue' => $this->OptionValue,
            'BranchID' => $this->BranchID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
