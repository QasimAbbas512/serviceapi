<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeJobPacketDtl;

/**
 * EmployeeJobPacketDtlSearch represents the model behind the search form of `app\models\EmployeeJobPacketDtl`.
 */
class EmployeeJobPacketDtlSearch extends EmployeeJobPacketDtl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'EmployeeID', 'PacketID', 'PacketCount', 'CalledNo', 'Pendings', 'Status', 'AssignedBy', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['AssignedOn', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = EmployeeJobPacketDtl::find();

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
            'EmployeeID' => $this->EmployeeID,
            'PacketID' => $this->PacketID,
            'PacketCount' => $this->PacketCount,
            'CalledNo' => $this->CalledNo,
            'Pendings' => $this->Pendings,
            'Status' => $this->Status,
            'AssignedOn' => $this->AssignedOn,
            'AssignedBy' => $this->AssignedBy,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedBy' => $this->DeletedBy,
            'DeletedOn' => $this->DeletedOn,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
