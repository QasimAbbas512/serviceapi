<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "social_medias".
 *
 * @property int $ID
 * @property string $MediaName
 * @property string $Description
 * @property int $TokenExpiry
 * @property string|null $Logo
 * @property string $Active
 * @property int $EnteredBy
 * @property string $EnteredOn
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property int $BranchID
 *
 * @property MediaLinkPosts[] $mediaLinkPosts
 * @property MediaLinks[] $mediaLinks
 * @property MediaPageRanking[] $mediaPageRankings
 * @property MediaPostRanking[] $mediaPostRankings
 */
class SocialMedias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_medias';
    }



    public function beforeSave($insert) {


        if ($insert) {

            CommonFunctions::selectMediaInfo($this->id,1);
        }else{//update event
            //delete cache keys
            CommonFunctions::selectMediaInfo($this->id,1);
            selectMediaQuery::selectMediaQuery($this->BranchID,1);

        }

        return parent::beforeSave($insert);

    }
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('media_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MediaName', 'Description', 'TokenExpiry', 'EnteredBy', 'EnteredOn', 'BranchID'], 'required'],
            [['Description'], 'string'],
            [['TokenExpiry', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['MediaName'], 'string', 'max' => 30],
            [['Logo'], 'string', 'max' => 50],
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
            'MediaName' => 'Media Name',
            'Description' => 'Description',
            'TokenExpiry' => 'Token Expiry',
            'Logo' => 'Logo',
            'Active' => 'Active',
            'EnteredBy' => 'Entered By',
            'EnteredOn' => 'Entered On',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[MediaLinkPosts]].
     *
     * @return \yii\db\ActiveQuery|PagesCredentialsQuery
     */
    public function getMediaLinkPosts()
    {
        return $this->hasMany(MediaLinkPosts::className(), ['MediaID' => 'ID']);
    }

    /**
     * Gets query for [[MediaLinks]].
     *
     * @return \yii\db\ActiveQuery|MediaLinksQuery
     */
    public function getMediaLinks()
    {
        return $this->hasMany(MediaLinks::className(), ['MediaID' => 'ID']);
    }

    /**
     * Gets query for [[MediaPageRankings]].
     *
     * @return \yii\db\ActiveQuery|SocialMediasQuery
     */
    public function getMediaPageRankings()
    {
        return $this->hasMany(MediaPageRanking::className(), ['MediaID' => 'ID']);
    }

    /**
     * Gets query for [[MediaPostRankings]].
     *
     * @return \yii\db\ActiveQuery|MediaPostRankingQuery
     */
    public function getMediaPostRankings()
    {
        return $this->hasMany(MediaPostRanking::className(), ['MediaID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return SocialMediasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SocialMediasQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
