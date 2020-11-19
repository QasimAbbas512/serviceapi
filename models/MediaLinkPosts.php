<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_link_posts".
 *
 * @property int $ID
 * @property int $MediaID
 * @property int $LinkID
 * @property string $PostType
 * @property string $PostURL
 * @property string $PostID
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property string $IsDeleted
 * @property int|null $DeletedBy
 * @property string|null $DeletedOn
 * @property int $BranchID
 *
 * @property MediaLinks $link
 * @property SocialMedias $media
 */
class MediaLinkPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_link_posts';
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
            [['MediaID', 'LinkID', 'PostType', 'PostURL', 'PostID', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['MediaID', 'LinkID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['EnteredOn', 'DeletedOn'], 'safe'],
            [['PostType'], 'string', 'max' => 5],
            [['PostURL'], 'string', 'max' => 150],
            [['PostID'], 'string', 'max' => 100],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['LinkID'], 'exist', 'skipOnError' => true, 'targetClass' => MediaLinks::className(), 'targetAttribute' => ['LinkID' => 'ID']],
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
            'LinkID' => 'Link ID',
            'PostType' => 'Post Type',
            'PostURL' => 'Post Url',
            'PostID' => 'Post ID',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'IsDeleted' => 'Is Deleted',
            'DeletedBy' => 'Deleted By',
            'DeletedOn' => 'Deleted On',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[Link]].
     *
     * @return \yii\db\ActiveQuery|MediaLinksQuery
     */
    public function getLink()
    {
        return $this->hasOne(MediaLinks::className(), ['ID' => 'LinkID']);
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
     * {@inheritdoc}
     * @return FbPagesCredentialsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PagesCredentialsQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
