<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property int $ID
 * @property string $ProjectName
 * @property string $Description
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property int|null $DeletedBy
 * @property string|null $DeletedOn
 * @property int $BranchID
 * @property int|null $CompanyID
 *
 * @property ClientInvestment[] $clientInvestments
 * @property ProjectGallery[] $projectGalleries
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }


    public function beforeSave($insert) {

        if ($insert) {
            $this->CompanyID = Yii::$app->session->get('company_id');

        }else{//update event

            $this->CompanyID = Yii::$app->session->get('company_id');
            CommonFunctions::selectProjectInfo($this->ID,$this->CompanyID,1);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectProjectInfo($this->ID,$this->CompanyID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProjectName', 'Description', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['EnteredBy', 'DeletedBy', 'BranchID', 'CompanyID'], 'integer'],
            [['ProjectName'], 'string', 'max' => 20],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ProjectName' => 'Project Name',
            'Description' => 'Description',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedBy' => 'Deleted By',
            'DeletedOn' => 'Deleted On',
            'BranchID' => 'Branch ID',
            'CompanyID' => 'Company ID',
        ];
    }

    /**
     * Gets query for [[ClientInvestments]].
     *
     * @return \yii\db\ActiveQuery|ClientInvestmentQuery
     */
    public function getClientInvestments()
    {
        return $this->hasMany(ClientInvestment::className(), ['ProjectID' => 'ID']);
    }

    /**
     * Gets query for [[ProjectGalleries]].
     *
     * @return \yii\db\ActiveQuery|ProjectGalleryQuery
     */
    public function getProjectGalleries()
    {
        return $this->hasMany(ProjectGallery::className(), ['ProjectID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectsQuery(get_called_class());
    }
}
