<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Complaints;

/**
 * ComplaintsSearch represents the model behind the search form of `app\models\Complaints`.
 */
class ComplaintsSearch extends Complaints
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'Category', 'RequestedBy', 'RequestedFor', 'Status', 'CompletedBy', 'ByDepartmentID', 'ForDepartmentID', 'EnteredBy', 'DeletedOn', 'DeletedBy', 'BranchID'], 'integer'],
            [['Heading', 'Description', 'CompletionDate', 'ComplaintDate', 'CompletedDate', 'Active', 'EnteredOn', 'IsDeleted'], 'safe'],
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
        $query = Complaints::find();

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
            'Category' => $this->Category,
            'RequestedBy' => $this->RequestedBy,
            'RequestedFor' => $this->RequestedFor,
            'CompletionDate' => $this->CompletionDate,
            'ComplaintDate' => $this->ComplaintDate,
            'Status' => $this->Status,
            'CompletedDate' => $this->CompletedDate,
            'CompletedBy' => $this->CompletedBy,
            'ByDepartmentID' => $this->ByDepartmentID,
            'ForDepartmentID' => $this->ForDepartmentID,
            'EnteredBy' => $this->EnteredBy,
            'EnteredOn' => $this->EnteredOn,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'Heading', $this->Heading])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
