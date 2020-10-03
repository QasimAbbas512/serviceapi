<?php

namespace app\models;

use Yii;
use CommonFunctions;

/**
 * This is the model class for table "company".
 *
 * @property int $CompanyID
 * @property string $CompanyName
 * @property string $Logo
 * @property string|null $Slogan
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property Users $enteredBy
 * @property CompanyBranches[] $companyBranches
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    public function beforeSave($insert) {

        if ($insert) {
            CommonFunctions::selectCompanyInfo($this->CompanyID,1);
        }else{//update event
            //delete cache keys
            CommonFunctions::selectCompanyInfo($this->CompanyID,1);
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CompanyName', 'EnteredOn', 'EnteredBy'], 'required'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['EnteredBy', 'DeletedBy'], 'integer'],
            [['CompanyName'], 'string', 'max' => 35],
            [['Logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['Logo'], 'string', 'max' => 50],
            [['Slogan'], 'string', 'max' => 250],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CompanyID' => 'Company ID',
            'CompanyName' => 'Company Name',
            'Logo' => 'Logo',
            'Slogan' => 'Slogan',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
        ];
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
     * Gets query for [[CompanyBranches]].
     *
     * @return \yii\db\ActiveQuery|CompanyBranchesQuery
     */
    public function getCompanyBranches()
    {
        return $this->hasMany(CompanyBranches::className(), ['CompanyID' => 'CompanyID']);
    }

    /**
     * {@inheritdoc}
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }
}
