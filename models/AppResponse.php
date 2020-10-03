<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_response".
 *
 * @property int $ID
 * @property string $ResponceHeading
 * @property string $InputType child data type is checkbox or radio button
 * @property string $AppUsed mobile app or web app or used by API
 * @property string $AppUserType App user type CSR or BDA or other
 * @property string $EventName
 * @property string|null $Description
 * @property string $Active
 * @property int $BranchID
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string|null $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property CompanyBranches $branch
 * @property Users $enteredBy
 */
class AppResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ResponceHeading', 'InputType', 'AppUsed', 'AppUserType', 'EventName', 'BranchID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['Description'], 'string'],
            [['BranchID', 'DeletedBy'], 'integer'],
            [['DeletedOn'], 'safe'],
            [['ResponceHeading'], 'string', 'max' => 50],
            [['InputType', 'AppUsed'], 'string', 'max' => 10],
            [['AppUserType', 'EventName'], 'string', 'max' => 20],
            [['IsDeleted', 'Active'], 'string', 'max' => 1],
            [['BranchID'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranches::className(), 'targetAttribute' => ['BranchID' => 'BranchID']],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ResponceHeading' => 'Responce Heading',
            'InputType' => 'Input Type',
            'AppUsed' => 'App Used',
            'AppUserType' => 'App User Type',
            'EventName' => 'Event Name',
            'Description' => 'Description',
            'Active' => 'Active',
            'BranchID' => 'Branch ID',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getBranch()
    {
        return $this->hasOne(CompanyBranches::className(), ['BranchID' => 'BranchID']);
    }

    /**
     * Gets query for [[EnteredBy]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getEnteredBy()
    {
        return $this->hasOne(User::className(), ['id' => 'EnteredBy']);
    }

    /**
     * {@inheritdoc}
     * @return AppResponseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppResponseQuery(get_called_class());
    }
}
