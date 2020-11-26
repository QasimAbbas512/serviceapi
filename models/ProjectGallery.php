<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_gallery".
 *
 * @property int $ID
 * @property int $ProjectID
 * @property string $ImageName
 * @property string $ImageFor web,android
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
 * @property Company $company
 * @property Projects $project
 */
class ProjectGallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProjectID', 'ImageName', 'Description', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['ProjectID', 'EnteredBy', 'DeletedBy', 'BranchID', 'CompanyID'], 'integer'],
            [['ImageFor', 'Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['ImageName'], 'string', 'max' => 50],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['CompanyID'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['CompanyID' => 'CompanyID']],
            [['ProjectID'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['ProjectID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ProjectID' => 'Project ID',
            'ImageName' => 'Image Name',
            'ImageFor' => 'Image For',
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
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery|CompanyQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['CompanyID' => 'CompanyID']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery|ProjectsQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['ID' => 'ProjectID']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectGalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectGalleryQuery(get_called_class());
    }
}
