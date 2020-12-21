<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_post_likedby".
 *
 * @property int $ID
 * @property string $PostID
 * @property int|null $PageID
 * @property string $ProfileName
 * @property string $Reaction
 * @property int|null $EmployeeID
 * @property string|null $RecordDate
 * @property string $Status N= no action, Y = Employee found, E = External User 
 * @property string|null $Enteredon
 * @property int|null $BranchID
 *
 * @property MediaLinks $page
 */
class MediaPostLikedby extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_post_likedby';
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
            [['PostID', 'ProfileName', 'Reaction'], 'required'],
            [['PageID', 'EmployeeID', 'BranchID'], 'integer'],
            [['RecordDate', 'Enteredon'], 'safe'],
            [['PostID'], 'string', 'max' => 150],
            [['ProfileName'], 'string', 'max' => 100],
            [['Reaction'], 'string', 'max' => 20],
            [['Status'], 'string', 'max' => 1],
            [['PageID'], 'exist', 'skipOnError' => true, 'targetClass' => MediaLinks::className(), 'targetAttribute' => ['PageID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PostID' => 'Post ID',
            'PageID' => 'Page ID',
            'ProfileName' => 'Profile Name',
            'Reaction' => 'Reaction',
            'EmployeeID' => 'Employee ID',
            'RecordDate' => 'Record Date',
            'Status' => 'Status',
            'Enteredon' => 'Enteredon',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(MediaLinks::className(), ['ID' => 'PageID']);
    }
}
