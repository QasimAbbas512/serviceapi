<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank_list".
 *
 * @property int $ID
 * @property string $BankName
 * @property int $CountryID
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property Users $enteredBy
 */
class BankList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BankName', 'CountryID', 'EnteredOn', 'EnteredBy'], 'required'],
            [['CountryID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['BankName'], 'string', 'max' => 50],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['EnteredBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['EnteredBy' => 'id']],
            [['CountryID'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['CountryID' => 'CountryID']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'BankName' => 'Bank Name',
            'CountryID' => 'Country ID',
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
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery|CountriesQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID']);
    }

    /**
     * {@inheritdoc}
     * @return BankListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BankListQuery(get_called_class());
    }
}
