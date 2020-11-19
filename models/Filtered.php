<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filtered_numbers".
 *
 * @property int $ID
 * @property string $Number
 * @property int|null $Assigned
 * @property string|null $ContactNotes
 *
 * @property JobPacketDtl[] $jobPacketDtls
 */
class Filtered extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filtered_numbers';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('contact_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Number'], 'required'],
            [['Assigned'], 'integer'],
            [['Number'], 'string', 'max' => 11],
            [['ContactNotes'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Number' => 'Number',
            'Assigned' => 'Assigned',
            'ContactNotes' => 'Contact Notes',
        ];
    }

    /**
     * Gets query for [[JobPacketDtls]].
     *
     * @return \yii\db\ActiveQuery|JobPacketDtlQuery
     */
    public function getJobPacketDtls()
    {
        return $this->hasMany(JobPacketDtl::className(), ['ContactID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return FilteredQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FilteredQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
