<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MediaLinkPosts;

/**
 * MediaLinkPostsSearch represents the model behind the search form of `app\models\MediaLinkPosts`.
 */
class MediaLinkPostsSearch extends MediaLinkPosts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'MediaID', 'LinkID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['PostType', 'PostURL', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = MediaLinkPosts::find();

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
            'LinkID' => $this->LinkID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedBy' => $this->DeletedBy,
            'DeletedOn' => $this->DeletedOn,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'PostType', $this->PostType])
            ->andFilterWhere(['like', 'PostURL', $this->PostURL])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
