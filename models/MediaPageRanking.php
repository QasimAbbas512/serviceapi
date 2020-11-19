<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_page_ranking".
 *
 * @property int $ID
 * @property int $MediaPageID
 * @property int $MediaID
 * @property string $RankingDate
 * @property int $TotalLikes
 * @property int $TotalShare
 * @property int $TotalComments
 * @property string $Active
 * @property string $EnteredOn
 * @property int $EnteredBy
 * @property int|null $DeletedBy
 * @property string $IsDeleted
 * @property string|null $DeletedOn
 * @property int $BranchID
 *
 * @property SocialMedias $media
 * @property MediaLinks $mediaPage
 */
class MediaPageRanking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_page_ranking';
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
            [['MediaPageID', 'MediaID', 'RankingDate', 'TotalLikes', 'TotalShare', 'TotalComments', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['MediaPageID', 'MediaID', 'TotalLikes', 'TotalShare', 'TotalComments', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['RankingDate', 'EnteredOn', 'DeletedOn'], 'safe'],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
            [['MediaID'], 'exist', 'skipOnError' => true, 'targetClass' => SocialMedias::className(), 'targetAttribute' => ['MediaID' => 'ID']],
            [['MediaPageID'], 'exist', 'skipOnError' => true, 'targetClass' => MediaLinks::className(), 'targetAttribute' => ['MediaPageID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MediaPageID' => 'Media Page ID',
            'MediaID' => 'Media ID',
            'RankingDate' => 'Ranking Date',
            'TotalLikes' => 'Total Likes',
            'TotalShare' => 'Total Share',
            'TotalComments' => 'Total Comments',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'EnteredBy' => 'Entered By',
            'DeletedBy' => 'Deleted By',
            'IsDeleted' => 'Is Deleted',
            'DeletedOn' => 'Deleted On',
            'BranchID' => 'Branch ID',
        ];
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
     * Gets query for [[MediaPage]].
     *
     * @return \yii\db\ActiveQuery|MediaLinksQuery
     */
    public function getMediaPage()
    {
        return $this->hasOne(MediaLinks::className(), ['ID' => 'MediaPageID']);
    }

    /**
     * {@inheritdoc}
     * @return MediaPageRankingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaPageRankingQuery(get_called_class());
    }

    public static function primaryKey()
    {
        return ["ID"];
    }
}
