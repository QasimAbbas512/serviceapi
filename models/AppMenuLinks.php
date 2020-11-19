<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_menu_links".
 *
 * @property int $ID
 * @property int $AppID
 * @property int $MenuID
 * @property string $LinkName
 * @property string|null $LinkTitle
 * @property string|null $LinkIcon
 * @property string|null $LinkClass
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 *
 * @property Applications $app
 * @property AppMenus $menu
 */
class AppMenuLinks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $links_array;
    public static function tableName()
    {
        return 'app_menu_links';
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::selectAppMenueLinks($this->AppID,$this->MenuID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AppID', 'MenuID', 'LinkName', 'AppUrl', 'EnteredOn', 'EnteredBy'], 'required'],
            [['AppID', 'MenuID', 'EnteredBy', 'DeletedBy'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['LinkName', 'LinkTitle'], 'string', 'max' => 100],
            [['AppUrl'], 'string', 'max' => 150],
            [['LinkIcon', 'LinkClass'], 'string', 'max' => 50],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['AppID'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['AppID' => 'ID']],
            [['MenuID'], 'exist', 'skipOnError' => true, 'targetClass' => AppMenus::className(), 'targetAttribute' => ['MenuID' => 'ID']],
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
            'MenuID' => 'Menu ID',
            'LinkName' => 'Link Name',
            'LinkTitle' => 'Link Title',
            'LinkIcon' => 'Link Icon',
            'LinkClass' => 'Link Class',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
        ];
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
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery|ApplicationsQuery
     */
    public function getMenu()
    {
        return $this->hasOne(AppMenus::className(), ['ID' => 'MenuID']);
    }

    /**
     * {@inheritdoc}
     * @return AppMenuLinksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppMenuLinksQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
