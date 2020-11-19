<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_links".
 *
 * @property int $ID
 * @property int $MediaID
 * @property string $PageName
 * @property string $PageLink
 * @property int $ProjectTypeID
 * @property string $CreatedBy
 * @property string $User
 * @property string|null $Password
 * @property string $Active
 * @property int $EnteredBy
 * @property string $EnteredOn
 * @property int|null $DeletedBy
 * @property string|null $DeletedOn
 * @property string $IsDeleted
 * @property int $BranchID
 *
 * @property MediaLinkPosts[] $mediaLinkPosts
 * @property SocialMedias $media
 * @property MediaPageRanking[] $mediaPageRankings
 */
class MediaLinks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_links';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('media_db');
    }

    public function afterSave($insert, $changedAttributes){

        CommonFunctions::loadMediaCount($this->MediaID,$this->BranchID,1);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MediaID', 'PageName', 'PageLink', 'ProjectTypeID', 'CreatedBy', 'User', 'EnteredBy', 'EnteredOn', 'BranchID'], 'required'],
            [['MediaID', 'ProjectTypeID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['CreatedBy'], 'string'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['PageName'], 'string', 'max' => 100],
            [['PageLink'], 'string', 'max' => 255],
            [['User'], 'string', 'max' => 150],
            [['Password'], 'string', 'max' => 15],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['MediaID'], 'exist', 'skipOnError' => true, 'targetClass' => SocialMedias::className(), 'targetAttribute' => ['MediaID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MediaID' => 'Media ID',
            'PageName' => 'Page Name',
            'PageLink' => 'Page Link',
            'ProjectTypeID' => 'Project Type ID',
            'CreatedBy' => 'Created By',
            'User' => 'User',
            'Password' => 'Password',
            'Active' => 'Active',
            'EnteredBy' => 'Entered By',
            'EnteredOn' => 'Entered On',
            'DeletedBy' => 'Deleted By',
            'DeletedOn' => 'Deleted On',
            'IsDeleted' => 'Is Deleted',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[MediaLinkPosts]].
     *
     * @return \yii\db\ActiveQuery|SocialMediasQuery
     */
    public function getMediaLinkPosts()
    {
        return $this->hasMany(MediaLinkPosts::className(), ['LinkID' => 'ID']);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery|SocialMediasQuery
     */
    public function getMedia()
    {
        return $this->hasOne(SocialMedias::className(), ['ID' => 'MediaID']);
    }

    /**
     * Gets query for [[MediaPageRankings]].
     *
     * @return \yii\db\ActiveQuery|SocialMediasQuery
     */
    public function getMediaPageRankings()
    {
        return $this->hasMany(MediaPageRanking::className(), ['MediaPageID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return MediaLinksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaLinksQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
