<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Particulers;

/**
 * ParticulersSearch represents the model behind the search form of `app\models\Particulers`.
 */
class ParticulersSearch extends Particulers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['PartculerName', 'Description', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = Particulers::find();

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
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'PartculerName', $this->PartculerName])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
