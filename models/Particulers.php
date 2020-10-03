<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "particulers".
 *
 * @property int $ID
 * @property string $PartculerName
 * @property string|null $Description
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property ParticulerTypes[] $particulerTypes
 * @property Users $enteredBy
 */
class Particulers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'particulers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PartculerName', 'EnteredOn', 'EnteredBy'], 'required'],
            [['Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['EnteredBy', 'DeletedBy'], 'integer'],
            [['PartculerName'], 'string', 'max' => 50],
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
            'ID' => 'ID',
            'PartculerName' => 'Partculer Name',
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
     * Gets query for [[ParticulerTypes]].
     *
     * @return \yii\db\ActiveQuery|ParticulerTypesQuery
     */
    public function getParticulerTypes()
    {
        return $this->hasMany(ParticulerTypes::className(), ['ParticulerID' => 'ID']);
    }

    /**
     * Gets query for [[EnteredBy]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getEntered()
    {
        return $this->hasOne(User::className(), ['id' => 'EnteredBy']);
    }

    /**
     * {@inheritdoc}
     * @return ParticulersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParticulersQuery(get_called_class());
    }
}
