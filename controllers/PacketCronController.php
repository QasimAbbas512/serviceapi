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
        if ($action->id == 'call' || $action->id == 'postman') {
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
    public function actionCall()
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


        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

            $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 limit '.$GetNodeRequestLimit;
            Yii::$app->machine_db->createCommand($sql)->execute();

              $call_record = NodeRequestedDate::find()->where('Status = 0 and Picked = 1 and Completed =0')->all();
               if(!empty($call_record)) {
                   $transaction = Yii::$app->db->beginTransaction();
                   try {
                       foreach ($call_record as $value) {

                           $row_id = $value->ID;
                           $PickedTime = date('Y-m-d H:i:s');

                           $requested_data = $value->DataPacket;
                           $data = json_decode($requested_data);

                           foreach ($data as $key => $val) {

                               $macAddress = $val->MacAddress;
                               $UserID = $val->UserID;
                               $user_info = CommonFunctions::UserInfo($UserID);
                               $call_request_branch = $user_info->BranchID;
                               $JobID = $val->JobID;
                               $CompanyID = $val->CompanyID;
                               $ContactID = $val->ContactID;
                               $ResponseValues = $val->ResponseValues;
                               $ProfileInfo = $val->ProfileInfo;
                               $VoiceCall = $val->VoiceCall;
                               $OtherNotes = $val->OtherNotes;
                               $AudioNote = $val->{'AudioNotes'};
                           }

                           $voice_note_audio_files = implode(',', (array)$AudioNote);

                           $model = new JobCallResponses();
                           $model->MacInfo = $macAddress;
                           $model->ContactID = $ContactID;
                           $model->ResponseID = $ResponseValues;
                           $model->UserID = $UserID;
                           $model->CallFilePath = $VoiceCall;
                           $model->OtherNote = $OtherNotes;
                           $model->PacketDtlID = $JobID;

                           $packet_record = CommonFunctions::JobPacketDtlInfo($JobID,$call_request_branch);//JobPacketDtl::find()->where(['ID' => $JobID])->one();
                           $packet_data = $packet_record->PacketID;

                           $model->JobPacketID = $packet_data;
                           $model->AudioNote = $voice_note_audio_files;
                           // echo '<pre>';
                           // print_r($voice_note_audio_files);
                           // exit();

                           $model->BranchID = $call_request_branch;
                           $model->EnteredOn = date('Y-m-d H:i:s');
                           $model->EnteredBy = 1;
                           $transaction2 = Yii::$app->db->beginTransaction();
                           try {
                               if ($model->save()) {
                                   $CompletedTime = date('Y-m-d H:i:s');
                                   $Tried = 1;
                                   $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';

                                   Yii::$app->machine_db->createCommand($update_status)->execute();
                               } //else {print_r($model->getErrors());exit();}
                               $transaction2->commit();

                           }catch(Exception $e) {
                               $transaction2->rollback();
                           }

                       }

                       $transaction->commit();

                   }catch(Exception $e) {
                        $transaction->rollback();
                        }
               }else{
                   echo 'No Data Found';exit();
               }

        
    }
    
  }