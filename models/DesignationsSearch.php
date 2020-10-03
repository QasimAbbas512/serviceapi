<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Designations;
use AppConstants;

/**
 * DesignationsSearch represents the model behind the search form of `app\models\Designations`.
 */
class DesignationsSearch extends Designations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['DesignationName', 'Description', 'Active', 'EnteredOn', 'IsDeleted', 'DeletedOn'], 'safe'],
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
        $query = Designations::find();
        //$query = Designations::find()->where(['BranchID' => Yii::$app->session->get('branch_id')])->andWhere(AppConstants::get_active_record_only)->all();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->query->andWhere('BranchID ='.Yii::$app->session->get('branch_id').' and '.AppConstants::get_active_record_only);
        //$dataProvider->query->andWhere(['BranchID' => Yii::$app->session->get('branch_id')]);
        //$dataProvider->query->andWhere(AppConstants::get_active_record_only);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             //$query->where('BranchID='. Yii::$app->session->get('branch_id'));
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'BranchID' => $this->BranchID,
            'EnteredOn' => $this->EnteredOn,
            'EnteredBy' => $this->EnteredBy,
            'DeletedOn' => $this->DeletedOn,
            'DeletedBy' => $this->DeletedBy,
        ]);

        $query->andFilterWhere(['like', 'DesignationName', $this->DesignationName])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Active', $this->Active])
            ->andFilterWhere(['like', 'IsDeleted', $this->IsDeleted]);

        return $dataProvider;
    }
}
