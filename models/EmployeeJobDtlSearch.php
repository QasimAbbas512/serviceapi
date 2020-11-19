<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeJobDtl;

/**
 * EmployeeJobDtlSearch represents the model behind the search form of `app\models\EmployeeJobDtl`.
 */
class EmployeeJobDtlSearch extends EmployeeJobDtl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'EmployeeID', 'DepartmentID', 'DesignationID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['IssuanceDate', 'IssuanceEndDate', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = EmployeeJobDtl::find();

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
            'DepartmentID' => $this->DepartmentID,
            'DesignationID' => $this->DesignationID,
            'IssuanceDate' => $this->IssuanceDate,
            'IssuanceEndDate' => $this->IssuanceEndDate,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
