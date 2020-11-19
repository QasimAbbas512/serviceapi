<?php

namespace app\models;

use Yii;
use CommonFunctions;
use AppConstants;

/**
 * This is the model class for table "app_menus".
 *
 * @property int $ID
 * @property int $AppID
 * @property string $MenuName
 * @property string|null $IconClass
 * @property string|null $IconImage
 * @property string|null $MenuTitle
 * @property string $Placement HeaderMenue, LeftMenue, RightMenue,FooterMenue
 * @property string $ChildLinks
 * @property string $MenuLink
 * @property string $Active
 * @property string $EnteredOn
 * @property int|null $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property AppMenuLinks[] $appMenuLinks
 * @property Applications $app
 */
class AppMenus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_menus';
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectAppMenues($this->AppID,$this->Placement,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AppID', 'MenuName', 'Placement', 'MenuLink', 'EnteredOn'], 'required'],
            [['AppID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['MenuName', 'MenuTitle', 'MenuLink'], 'string', 'max' => 30],
            [['IconClass', 'IconImage'], 'string', 'max' => 150],
            [['Placement'], 'string', 'max' => 11],
            [['ChildLinks', 'Active', 'IsDeleted'], 'string', 'max' => 1],
            [['AppID'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['AppID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'AppID' => 'App ID',
            'MenuName' => 'Menu Name',
            'IconClass' => 'Icon Class',
            'IconImage' => 'Icon Image',
            'MenuTitle' => 'Menu Title',
            'Placement' => 'Placement',
            'ChildLinks' => 'Child Links',
            'MenuLink' => 'Menu Link',
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
        return $this->hasMany(AppMenuLinks::className(), ['MenuID' => 'ID']);
    }

    /**
     * Gets query for [[App]].
     *
     * @return \yii\db\ActiveQuery|ApplicationsQuery
     */
    public function getApp()
    {
        return $this->hasOne(Applications::className(), ['ID' => 'AppID']);
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
