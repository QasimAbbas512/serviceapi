<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employees;
use AppConstants;

/**
 * EmployeesSearch represents the model behind the search form of `app\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'SalutationID', 'MaritalStatus', 'BloodGroup', 'DesignationID', 'DepartmentID', 'BankID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['FirstName', 'MiddleName', 'LastName', 'FullName', 'GuardianRelation', 'GuardianName', 'DateOfBirth', 'Gender', 'CellNo', 'CNIC', 'ImageName', 'Email', 'Address', 'AttMachineNo', 'JoiningDate', 'ExpireDate', 'NTN_No', 'AccountNo', 'AccountTitle', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = Employees::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->query->andWhere('BranchID ='.Yii::$app->session->get('branch_id').' and '.AppConstants::get_active_record_only);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'SalutationID' => $this->SalutationID,
            'DateOfBirth' => $this->DateOfBirth,
            'MaritalStatus' => $this->MaritalStatus,
            'BloodGroup' => $this->BloodGroup,
            'DesignationID' => $this->DesignationID,
            'DepartmentID' => $this->DepartmentID,
            'JoiningDate' => $this->JoiningDate,
            'ExpireDate' => $this->ExpireDate,
            'BankID' => $this->BankID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
            'BranchID' => $this->BranchID,
        ]);

        $query->andFilterWhere(['like', 'FirstName', $this->FirstName])
            ->andFilterWhere(['like', 'MiddleName', $this->MiddleName])
            ->andFilterWhere(['like', 'LastName', $this->LastName])
            ->andFilterWhere(['like', 'FullName', $this->FullName])
            ->andFilterWhere(['like', 'GuardianRelation', $this->GuardianRelation])
            ->andFilterWhere(['like', 'GuardianName', $this->GuardianName])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'CellNo', $this->CellNo])
            ->andFilterWhere(['like', 'CNIC', $this->CNIC])
            ->andFilterWhere(['like', 'ImageName', $this->ImageName])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'Address', $this->Address])
            ->andFilterWhere(['like', 'AttMachineNo', $this->AttMachineNo])
            ->andFilterWhere(['like', 'NTN_No', $this->NTN_No])
            ->andFilterWhere(['like', 'AccountNo', $this->AccountNo])
            ->andFilterWhere(['like', 'AccountTitle', $this->AccountTitle])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
