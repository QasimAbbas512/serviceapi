<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_response_dtl".
 *
 * @property int $ID
 * @property int $ResponseHeadID
 * @property string $OptionText
 * @property string|null $OptionValue
 * @property string|null $Description
 * @property string $Active
 * @property int $BranchID
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string|null $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property AppResponse $responseHead
 * @property CompanyBranches $branch
 * @property Users $enteredBy
 */
class AppResponseDtl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_response_dtl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ResponseHeadID', 'OptionText', 'BranchID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['ResponseHeadID', 'BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['OptionText', 'OptionValue'], 'string', 'max' => 30],
            [['ResponseHeadID'], 'exist', 'skipOnError' => true, 'targetClass' => AppResponse::className(), 'targetAttribute' => ['ResponseHeadID' => 'ID']],
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
            'ResponseHeadID' => 'Response Head ID',
            'OptionText' => 'Option Text',
            'OptionValue' => 'Option Value',
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
     * Gets query for [[ResponseHead]].
     *
     * @return \yii\db\ActiveQuery|AppResponseQuery
     */
    public function getResponseHead()
    {
        return $this->hasOne(AppResponse::className(), ['ID' => 'ResponseHeadID']);
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
     * @return AppResponseDtlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppResponseDtlQuery(get_called_class());
    }
}
