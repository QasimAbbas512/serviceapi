<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_mobile_info".
 *
 * @property int $ID
 * @property int $EmpID
 * @property string $DeviceMac
 * @property string $UserType
 * @property string $TokenInfo
 * @property string $Active
 * @property int $BranchID
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 */
class UserMobileInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_mobile_info';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('machine_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmpID', 'DeviceMac', 'TokenInfo', 'BranchID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['EmpID', 'BranchID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['DeviceMac'], 'string', 'max' => 150],
            [['UserType'], 'string', 'max' => 4],
            [['TokenInfo'], 'string', 'max' => 255],
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
            'EmpID' => 'Emp ID',
            'DeviceMac' => 'Device Mac',
            'UserType' => 'User As',
            'TokenInfo' => 'Token Info',
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
     * {@inheritdoc}
     * @return UserMobileInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserMobileInfoQuery(get_called_class());
    }

    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['ID' => 'EmpID']);
    }
}
