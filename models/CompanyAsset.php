<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_asset".
 *
 * @property int $ID
 * @property string $AssetName
 * @property int $TypeID
 * @property string|null $Description
 * @property string $Active
 * @property int $BranchID
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property ParticulerTypes $type
 * @property EmployeeAllocatedAsset[] $employeeAllocatedAssets
 */
class CompanyAsset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_asset';
    }


    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectCompanyAssetInfo($this->ID,$this->BranchID,1);
        CommonFunctions::loadCompanyAssets($this->BranchID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AssetName', 'TypeID', 'BranchID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['TypeID', 'BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['AssetName'], 'string', 'max' => 30],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['TypeID'], 'exist', 'skipOnError' => true, 'targetClass' => ParticulerTypes::className(), 'targetAttribute' => ['TypeID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'AssetName' => 'Asset Name',
            'TypeID' => 'Type ID',
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
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getType()
    {
        return $this->hasOne(ParticulerTypes::className(), ['ID' => 'TypeID']);
    }

    /**
     * Gets query for [[EmployeeAllocatedAssets]].
     *
     * @return \yii\db\ActiveQuery|EmployeeAllocatedAssetQuery
     */
    public function getEmployeeAllocatedAssets()
    {
        return $this->hasMany(EmployeeAllocatedAsset::className(), ['AssetID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return CompanyAssetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyAssetQuery(get_called_class());
    }
}
