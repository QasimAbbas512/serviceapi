<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications".
 *
 * @property int $ID
 * @property string $AppName
 * @property string|null $Description
 * @property string $Active
 * @property string $EnteredOn
 * @property int|null $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property AppMenuLinks[] $appMenuLinks
 * @property AppMenus[] $appMenuses
 */
class Applications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AppName', 'EnteredOn'], 'required'],
            [['Description'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['EnteredBy', 'DeletedBy'], 'integer'],
            [['AppName'], 'string', 'max' => 50],
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
            'AppName' => 'App Name',
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
     * Gets query for [[AppMenuLinks]].
     *
     * @return \yii\db\ActiveQuery|AppMenuLinksQuery
     */
    public function getAppMenuLinks()
    {
        return $this->hasMany(AppMenuLinks::className(), ['AppID' => 'ID']);
    }

    /**
     * Gets query for [[AppMenuses]].
     *
     * @return \yii\db\ActiveQuery|AppMenusQuery
     */
    public function getAppMenuses()
    {
        return $this->hasMany(AppMenus::className(), ['AppID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return ApplicationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApplicationsQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
