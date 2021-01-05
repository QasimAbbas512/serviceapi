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

class CallResponseController extends Controller
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

//        $call_action_data = '[{"MacAddress":"WSD3:9l:440:45",
//         "UserID":"1",
//         "JobID":"1",
//         "CompanyID":"1",
//         "ContactID":"5",
//         "ResponseValues":"3",
//         "ProfileInfo":"Address location area etc",
//         "VoiceCall":"CallFileName.aac",
//         "OtherNotes":"text notes",
//         "AudioNotes":{"0":"VoiceNote1.aac","1":"VoiceNote2.aac","2":"VoiceNote3.aac"}}]';


        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

        $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 and RequestDestination = "call_response" limit ' . $GetNodeRequestLimit;
        Yii::$app->machine_db->createCommand($sql)->execute();

        $call_record = NodeRequestedDate::find()->where('Status = 0 and Picked = 1 and Completed =0 and RequestDestination = "call_response"')->all();
//        echo '<pre>';
//        print_r($call_record);
//        exit();
        if (!empty($call_record)) {

            $transaction = Yii::$app->contact_db->beginTransaction();
            try {
                foreach ($call_record as $value) {

                    $row_id = $value->ID;
                    $PickedTime = date('Y-m-d H:i:s');

                    $requested_data = $value->DataPacket;
                    $data = json_decode($requested_data);
                    $val = $data;
//                    echo '<pre>';
//                    print_r($val);
//                    echo $val->MacAddress;
//                    exit();
                    //foreach ($data as $key => $val) {

                        $UUID = $val->UUID;
                        $chk = JobCallResponses::find()->where(['UUID'=>$UUID])->one();
                        if(empty($chk)){
                            $job_message = 'UUID Already Added';
//                            $update_msg = 'update node_requested_date set status = 1, Completed = 1,  job_message = "'.$job_message.'"  where ID = "' . $row_id . '"';
//                            Yii::$app->machine_db->createCommand($update_msg)->execute();
                            //continue;
                        }
                        $macAddress = $val->MacAddress;
                        $UserID = $val->UserID;
                        $user_info = CommonFunctions::UserInfo($UserID);
                        $call_request_branch = $user_info->BranchID;
                        $JobID = $val->JobID;
                        $CompanyID = $val->CompanyID;
                        $ContactID = $val->ContactID;
                        if(!empty($val->Skip)){
                            $ResponseValues = AppConstants::SkipValue;
                            $OtherNotes = $val->Skip;
                        }else {
                            $ResponseValues = $val->ResponseValues;
                            $OtherNotes = $val->OtherNotes;
                        }

                        $ProfileInfo = $val->ProfileInfo;
                        if(!empty($val->VoiceCall)) {
                            $VoiceCall = $val->VoiceCall;
                        }else{
                            $VoiceCall = 'NoCall';
                        }

                        if(!empty($val->AudioNotes)) {
                            $AudioNote = $val->AudioNotes;
                        }else{
                            $AudioNote = 'NoVoiceNote';
                        }
                        //$AudioNote = $val->{'AudioNotes'};

                        // for the time we consider only one voice note comming or it can be null also next we will update this
                        //$voice_note_audio_files = implode(',', (array)$AudioNote);

                        $model = new JobCallResponses();
                        $model->MacInfo = $macAddress;
                        $model->ContactID = $ContactID;
                        $model->ResponseID = $ResponseValues;
                        $model->UserID = $UserID;
                        $model->CallFilePath = $VoiceCall;
                        $model->OtherNote = $OtherNotes;
                        $model->PacketDtlID = $JobID;

                        $packet_record = CommonFunctions::JobPacketDtlInfo($JobID, $call_request_branch);//JobPacketDtl::find()->where(['ID' => $JobID])->one();
                        $packet_data = $packet_record->PacketID;

                        $model->JobPacketID = $packet_data;
                        $model->AudioNote = $AudioNote;//$voice_note_audio_files;
                        // echo '<pre>';
                        // print_r($voice_note_audio_files);
                        // exit();

                        $model->UUID = $UUID;
                        $model->BranchID = $call_request_branch;
                        $model->EnteredOn = date('Y-m-d H:i:s');
                        $model->EnteredBy = 1;
                        $transaction2 = Yii::$app->contact_db->beginTransaction();
                        try {
                            if ($model->save()) {
                                $CompletedTime = date('Y-m-d H:i:s');
                                $Tried = 1;
                                $job_message = 'Executed Successfully';
                                $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", job_message = "'.$job_message.'", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';
                                Yii::$app->machine_db->createCommand($update_status)->execute();

                                $transaction2->commit();
                            } else {print_r($model->getErrors());exit();}


                        } catch (Exception $e) {
                            $transaction2->rollback();
                        }
                    //}
                }

                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollback();
            }
            echo 'Job Done';
            exit();
        } else {
            echo 'No Data Found';
            exit();
        }


    }

}