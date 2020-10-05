<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JobCallResponses;

/**
 * JobCallResponsesSearch represents the model behind the search form of `app\models\JobCallResponses`.
 */
class JobCallResponsesSearch extends JobCallResponses
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'PacketDtlID', 'JobPacketID', 'ContactID', 'ResponseID', 'UserID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['CallFilePath', 'AudioNote', 'OtherNote', 'MacInfo', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = JobCallResponses::find();

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
            'PacketDtlID' => $this->PacketDtlID,
            'JobPacketID' => $this->JobPacketID,
            'ContactID' => $this->ContactID,
            'ResponseID' => $this->ResponseID,
            'UserID' => $this->UserID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'CallFilePath', $this->CallFilePath])
            ->andFilterWhere(['like', 'AudioNote', $this->AudioNote])
            ->andFilterWhere(['like', 'OtherNote', $this->OtherNote])
            ->andFilterWhere(['like', 'MacInfo', $this->MacInfo])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
