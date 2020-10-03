<?php

namespace app\models;

use Yii;
use CommonFunctions;
use yii\db\Query;
use yii\db\BaseActiveRecord;
use yii\base\Behavior;
/**
 * This is the model class for table "designations".
 *
 * @property int $ID
 * @property string $DesignationName
 * @property string|null $Description
 * @property string $Active
 * @property int $BranchID
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property CompanyBranches $branch
 * @property Users $enteredBy
 * @property Employees[] $employees
 */
class Designations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designations';
    }

    public function beforeSave($insert) {

        if ($insert) {
            $this->BranchID = Yii::$app->session->get('branch_id');
            $this->EnteredBy = Yii::$app->session->get('user_id');
            $this->EnteredOn = date('Y-m-d H:i:s');
        }else{//update event

            $this->BranchID = Yii::$app->session->get('branch_id');
            $this->EnteredBy = Yii::$app->session->get('user_id');
            $this->EnteredOn = date('Y-m-d H:i:s');
            //delete cache keys
            CommonFunctions::selectDesignationInfo($this->ID,$this->BranchID,1);
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectDesignationInfo($this->ID,$this->BranchID,1);
        CommonFunctions::loadDesignations($this->BranchID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DesignationName', 'BranchID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['Description'], 'string'],
            [['BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['DesignationName'], 'string', 'max' => 50],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
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
            'DesignationName' => 'Designation Name',
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
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['DesignationID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return DesignationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DesignationsQuery(get_called_class());
    }
}
