<?php

namespace app\models;

use Yii;
use CommonFunctions;
/**
 * This is the model class for table "particuler_types".
 *
 * @property int $ID
 * @property int $ParticulerID
 * @property string $ListOptionName
 * @property string|null $Acronym
 * @property string|null $Description
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property Employees[] $employees
 * @property Particulers $particuler
 * @property Users $enteredBy
 */
class ParticulerTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'particuler_types';
    }

    public function beforeSave($insert) {

        if ($insert) {

        }else{//update event
            //delete cache keys
            //CommonFunctions::selectDesignationInfo($this->ID,$this->BranchID,1);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::loadListValues($this->ParticulerID,1);
        CommonFunctions::selectParticulerTypeInfo($this->ParticulerID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ParticulerID', 'ListOptionName', 'EnteredOn', 'EnteredBy'], 'required'],
            [['ParticulerID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['ListOptionName'], 'string', 'max' => 50],
            [['Acronym'], 'string', 'max' => 10],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['ParticulerID'], 'exist', 'skipOnError' => true, 'targetClass' => Particulers::className(), 'targetAttribute' => ['ParticulerID' => 'ID']],
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
            'ParticulerID' => 'Particuler ID',
            'ListOptionName' => 'List Option Name',
            'Acronym' => 'Acronym',
            'Description' => 'Description',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['SalutationID' => 'ID']);
    }

    /**
     * Gets query for [[Particuler]].
     *
     * @return \yii\db\ActiveQuery|ParticulersQuery
     */
    public function getParticuler()
    {
        return $this->hasOne(Particulers::className(), ['ID' => 'ParticulerID']);
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
     * @return ParticulerTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParticulerTypesQuery(get_called_class());
    }
}
