<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MediaLinks;

/**
 * MediaLinksSearch represents the model behind the search form of `app\models\MediaLinks`.
 */
class MediaLinksSearch extends MediaLinks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'MediaID', 'CreatedBy', 'User', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['PageLink', 'Password', 'Active', 'EnteredOn', 'DeletedOn', 'IsDeleted'], 'safe'],
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
        $query = MediaLinks::find();

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
            'MediaID' => $this->MediaID,
            'CreatedBy' => $this->CreatedBy,
            'User' => $this->User,
            'EnteredBy' => $this->EnteredBy,
            'EnteredOn' => $this->EnteredOn,
            'DeletedBy' => $this->DeletedBy,
            'DeletedOn' => $this->DeletedOn,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'PageLink', $this->PageLink])
            ->andFilterWhere(['like', 'Password', $this->Password])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
