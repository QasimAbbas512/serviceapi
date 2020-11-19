<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SocialMedias;

/**
 * SocialMediasSearch represents the model behind the search form of `app\models\SocialMedias`.
 */
class SocialMediasSearch extends SocialMedias
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['MediaName', 'Description', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = SocialMedias::find();

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
            'EnteredBy' => $this->EnteredBy,
            'EnteredOn' => $this->EnteredOn,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'MediaName', $this->MediaName])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
