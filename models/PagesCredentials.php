<?php

namespace app\models;

use Yii;
use CommonFunctions;
use AppConstants;
use app\models\SocialMedias;
use app\models\MediaLinks;

/**
 * This is the model class for table "pages_credentials".
 *
 * @property int $ID
 * @property int $PageID
 * @property string $AppID
 * @property string $AppSecret
 * @property string $PageUserID
 * @property string $PageToken
 * @property string $Active
 * @property string $EnteredOn
 * @property string|null $TokenExpiryDate
 * @property string|null $AlertDate
 * @property int $EnteredBy
 * @property string|null $DeletedOn
 * @property int|null $DeletedBy
 * @property string $IsDeleted
 * @property int $BranchID
 *
 * @property MediaLinks $page
 */
class PagesCredentials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages_credentials';
    }

    public function beforeSave($insert) {


        if ($insert) {
            $page_info = MediaLinks::find()->where(['ID' =>$this->PageID])->one();
            if(!empty($page_info)) {
                $media_info = CommonFunctions::selectMediaInfo($page_info->MediaID);
                $token_expire_days = $media_info->TokenExpiry;
                $the_date = date('Y-m-d');
                $expiry_date = date('Y-m-d', strtotime('+'.$token_expire_days.' day',strtotime($the_date)));

                $alert_date = date('Y-m-d', strtotime('-'.AppConstants::social_media_alert_date.' day',strtotime($expiry_date)));

                $this->TokenExpiryDate = $expiry_date;
                $this->AlertDate = $alert_date;

                //echo $alert_date.'--'.$expiry_date;exit();
            }
        }else{

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
            [['PageID', 'AppID', 'AppSecret', 'PageUserID', 'PageToken', 'EnteredOn', 'EnteredBy', 'BranchID'], 'required'],
            [['PageID', 'EnteredBy', 'DeletedBy', 'BranchID'], 'integer'],
            [['PageToken'], 'string'],
            [['EnteredOn', 'TokenExpiryDate', 'AlertDate', 'DeletedOn'], 'safe'],
            [['AppID', 'PageUserID'], 'string', 'max' => 50],
            [['AppSecret'], 'string', 'max' => 100],
            [['Active', 'IsDeleted'], 'string', 'max' => 1],
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
            'PageID' => 'Page ID',
            'AppID' => 'App ID',
            'AppSecret' => 'App Secret',
            'PageUserID' => 'Page User ID',
            'PageToken' => 'Page Token',
            'Active' => 'Active',
            'EnteredOn' => 'Entered On',
            'TokenExpiryDate' => 'Token Expiry Date',
            'AlertDate' => 'Alert Date',
            'EnteredBy' => 'Entered By',
            'DeletedOn' => 'Deleted On',
            'DeletedBy' => 'Deleted By',
            'IsDeleted' => 'Is Deleted',
            'BranchID' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery|MediaLinksQuery
     */
    public function getPage()
    {
        return $this->hasOne(MediaLinks::className(), ['ID' => 'PageID']);
    }

    /**
     * {@inheritdoc}
     * @return PagesCredentialsQuery the active query used by this AR class.
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
