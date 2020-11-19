<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FbPagesCredentials;

/**
 * FbPagesCredentialsSearch represents the model behind the search form of `app\models\FbPagesCredentials`.
 */
class FbPagesCredentialsSearch extends FbPagesCredentials
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'PageID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['AppID', 'AppSecret', 'PageToken', 'PostID', 'Active', 'EnteredOn', 'DeletedOn', 'IsDeleted'], 'safe'],
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
        $query = FbPagesCredentials::find();

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
            'PageID' => $this->PageID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'AppID', $this->AppID])
            ->andFilterWhere(['like', 'AppSecret', $this->AppSecret])
            ->andFilterWhere(['like', 'PageToken', $this->PageToken])
            ->andFilterWhere(['like', 'PostID', $this->PostID])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
