<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppMenus;

/**
 * AppMenusSearch represents the model behind the search form of `app\models\AppMenus`.
 */
class AppMenusSearch extends AppMenus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'AppID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['MenuName', 'IconClass', 'IconImage', 'MenuTitle', 'Placement', 'ChildLinks', 'MenuLink', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = AppMenus::find();

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
            'AppID' => $this->AppID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'MenuName', $this->MenuName])
            ->andFilterWhere(['like', 'IconClass', $this->IconClass])
            ->andFilterWhere(['like', 'IconImage', $this->IconImage])
            ->andFilterWhere(['like', 'MenuTitle', $this->MenuTitle])
            ->andFilterWhere(['like', 'Placement', $this->Placement])
            ->andFilterWhere(['like', 'ChildLinks', $this->ChildLinks])
            ->andFilterWhere(['like', 'MenuLink', $this->MenuLink])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
