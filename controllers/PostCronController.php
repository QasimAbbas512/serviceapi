<?php
/**
 * Yii2 test controller
 *
 * @category  Web-yii2-example
 * @package   yii2-curl-example
 * @author    Nils Gajsek <info@linslin.org>
 * @copyright 2013-2015 Nils Gajsek<info@linslin.org>
 * @license   http://opensource.org/licenses/MIT MIT Public
 * @version   1.0.5
 * @link      http://www.linslin.org
 *
 */

namespace app\controllers;
use app\models\MediaPostRanking;
use Yii;
use app\models\NodeRequestedDate;
use app\models\JobCallResponses;
use app\models\JobPacketDtl;
use app\models\JobPackets;
use CommonFunctions;
use AppConstants;
use GetParams;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use linslin\yii2\curl;

class PacketCronController extends Controller
{

    /**
     * Yii action controller
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'ranking' || $action->id == 'postman') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * cURL GET example
     */

    /**
     * Call from cron job to explore data sent by mobile and distribute into tables as per requirement / given data
     */
    public function actionRanking()
    {

        // $call_action_data = '[{"MacAddress":"WSD3:9l:440:45",
        // "UserID":"1",
        // "JobID":"1",
        // "CompanyID":"1",
        // "ContactID":"1",
        // "ResponseValues":"3",
        // "ProfileInfo":"Address location area etc",
        // "VoiceCall":"CallFileName.aac",
        // "OtherNotes":"text notes",
        // "AudioNotes":{"0":"VoiceNote1.aac","1":"VoiceNote2.aac","2":"VoiceNote3.aac"}}]';

//        [{"AppID":"281717699831859 ",
//        "AppSecret":"e3d0cb76a6589dc9d7382e12397bc05c",
//        "PageToken":"EAAEAOINs6DMBAHxh61uSS8RsXLorGZBLUqbr3jetxXCIEXq5ZAVmMVPhee4ALr1xlFL6JNZBLZAxyJKntQQZB3Cp0xTwQetCoyYDLRxEw4juRcYkjve7KPFS3Oj4l28K1sbrxRQzZAk040Yxzzn9wm2uMoKog0gvlyS5wPfJOoU2VJD206nAJ3",
//        "PageUserID":"109747260742499"}]


        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

        $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 limit ' . $GetNodeRequestLimit;
        Yii::$app->machine_db->createCommand($sql)->execute();

        $post_record = NodeRequestedDate::find()->where('Status = 0 and Picked = 1 and Completed =0')->all();
        if (!empty($post_record)) {


            foreach ($post_record as $value) {

                $row_id = $value->ID;
                $PickedTime = date('Y-m-d H:i:s');

                $requested_data = $value->DataPacket;
                $data = json_decode($requested_data);

                foreach ($data as $key => $val) {

                    $app_id = $val->AppID;
                    $AppSecret = $val->AppSecret;
                    $PageToken = $val->PageToken;
                    $pageID = $val->PageUserID;
                    $page_row_id = $val->PageId;


                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

                    $i = 0;
                    foreach ($body_data as $k) {
                        $i++;
                        $post_id = '';
                        $created_time = '';
                        $likes = 0;
                        $shares = 0;
                        $total_shares = 0;
                        $total_likes = 0;

                        $created_time_val = $k->created_time;
                        $id = $k->id;
                        $reactions_array = $k->reactions;
                        $shar_array = $k->shares;

//                        echo '<pre>';
//                        print_r($shar_array);
//                        exit();

                        foreach ($reactions_array as $x => $reac_vals) {
                            if (!empty($reac_vals->total_count)) {
                                $total_likes = $reac_vals->total_count;
                            }
                        }

//                        foreach ($shar_array as $p => $share_vals) {
//                            $total_shares = $share_vals;
//                        }
                        if (!empty($shar_array->count)) {
                            $total_shares = $shar_array->count;
                        }

                        $post_value_id = explode('_', $id);
                        $post_id = $post_value_id[1];
                        $created_time = date('Y-m-d H:i:s', strtotime($created_time_val));
                        $date = date('Y-m-d');
                        $likes = $total_likes;
                        $shares = $total_shares;

                        $model = new MediaPostRanking();
                        $model->CreatedOn = $created_time;
                        $model->PostID = $post_id;
                        $model->TotalShare = $shares;
                        $model->CountDate = $date;
                        $model->MediaID = 1;
                        $model->MediaPageID = $page_row_id;
                        $model->TotalLikes = $likes;
                        $model->Active = 'Y';
                        $model->EnteredOn = date('Y-m-d H:i:s');
                        $model->EnteredBy = 2;
                        $model->BranchID = 2;
                        $model->IsDeleted = 'N';

                        $validation = MediaPostRanking::find()->where(['PostID' => $post_id])->andWhere(['MediaPageID' => $page_row_id])->andWhere(['CountDate' => $date])->one();
                        if (!empty($validation)) {
                            continue;
                        }

                        if ($model->save()) {
                            $CompletedTime = date('Y-m-d H:i:s');
                            $Tried = 1;
                            $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';

                            Yii::$app->machine_db->createCommand($update_status)->execute();
                        } //else {print_r($model->getErrors());exit();}


                        else {
                            echo 'No Data Found';
                            exit();
                        }

                    }
                }

            }
        }
    }
}

