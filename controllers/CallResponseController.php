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

use app\models\EmployeeJobPacketDtl;
use Yii;
use app\models\NodeRequestedDate;
use app\models\JobCallResponses;
use app\models\AppResponseDtl;
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
        if ($action->id == 'call' || $action->id == 'postman' || $action->id == 'runlike') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * cURL GET example
     */
    public function actionRunlike(){
        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

        $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 and RequestDestination = "add_likes" limit ' . $GetNodeRequestLimit;
        Yii::$app->machine_db->createCommand($sql)->execute();

        $call_record = NodeRequestedDate::find()->where('Status = 0 and Picked = 1 and Completed =0 and RequestDestination = "add_likes"')->all();
        if (!empty($call_record)) {
            foreach ($call_record as $value) {

                $row_id = $value->ID;
                $PickedTime = date('Y-m-d H:i:s');

                $requested_data = $value->DataPacket;
                $data = json_decode($requested_data);
                $val = $data;
                $empid = $val->empid;
                $ToDate = $val->ToDate;
                $FromDate = $val->FromDate;
                $branchID = $val->branchID;
                CommonFunctions::likedBy($empid,$ToDate,$FromDate,$branchID);
                $CompletedTime = date('Y-m-d H:i:s');
                $Tried = 1;
                $job_message = 'Executed Successfully';
                $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", job_message = "' . $job_message . '", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';
                Yii::$app->machine_db->createCommand($update_status)->execute();

            }
        }
        echo 'Done';
        exit();
    }
    /**
     * Call from cron job to explore data sent by mobile and distribute into tables as per requirement / given data
     */
    public function actionCall()
    {
        header("Refresh: 50");
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
                    $macAddress = $val->MacAddress;
                    $UserID = $val->UserID;

                    $user_info = CommonFunctions::UserInfo($UserID);
                    $call_request_branch = $user_info->BranchID;
                    $employee_id = $user_info->EmpID;

                    $JobID = $val->JobID;

                    $team_id = $val->TeamID;

                    $packet_record = CommonFunctions::JobPacketDtlInfo($JobID, $call_request_branch);//JobPacketDtl::find()->where(['ID' => $JobID])->one();
                    $packet_data = $packet_record->PacketID;

                    if(empty($team_id)){
                        $job_pkt_info = EmployeeJobPacketDtl::find()->where(['PacketID'=>$packet_data])->one();
                        $team_id = $job_pkt_info->TeamID;
                    }

                    $ContactID = $val->ContactID;

                    //$chk = JobCallResponses::find()->where(['UUID'=>$UUID])->andWhere(['PacketDtlID'=>$JobID])->andWhere(['TeamID'=>$team_id])->one();

                    $chk = Yii::$app->contact_db->createCommand("select ID from job_call_responses where PacketDtlID =" . $JobID . " and TeamID=" . $team_id . " and UUID='" . $UUID . "'")->queryOne();
//                        echo '<pre>';
//                        echo count($chk);
//                        print_r($chk);
//                        exit();

                    if (empty($chk) || count($chk) == 0) {

                        //continue;

                        if (!empty($val->Skip)) {
                            $ResponseValues = AppConstants::SkipValue;
                            $OtherNotes = $val->Skip;
                        } else {
                            $ResponseValues = $val->ResponseValues;
                            $OtherNotes = $val->OtherNotes;
                        }

                        $ProfileInfo = $val->ProfileInfo;
                        if (!empty($val->VoiceCall)) {
                            $VoiceCall = $val->VoiceCall;
                        } else {
                            $VoiceCall = 'NoCall';
                        }

                        if (!empty($val->AudioNotes)) {
                            $AudioNote = $val->AudioNotes;
                        } else {
                            $AudioNote = 'NoVoiceNote';
                        }

                        $action = CommonFunctions::ResponseActions($ResponseValues);

                        //$AudioNote = $val->{'AudioNotes'};

                        // for the time being we consider only one voice note comming or it can be null also next we will update this
                        //$voice_note_audio_files = implode(',', (array)$AudioNote);

                        $model = new JobCallResponses();
                        $model->MacInfo = $macAddress;
                        $model->ContactID = $ContactID;
                        $model->ResponseID = $ResponseValues;
                        $model->UserID = $UserID;
                        $model->EmployeeID = $employee_id;
                        $model->TeamID = $team_id;
                        $model->CallFilePath = $VoiceCall;
                        $model->OtherNote = $OtherNotes;
                        $model->PacketDtlID = $JobID;

                        $packet_record = CommonFunctions::JobPacketDtlInfo($JobID, $call_request_branch, 1);//JobPacketDtl::find()->where(['ID' => $JobID])->one();
                        $packet_data = $packet_record->PacketID;

                        $packets_arr[] = $packet_data;

                        $model->JobPacketID = $packet_data;
                        $model->AudioNote = $AudioNote;//$voice_note_audio_files;
                        // echo '<pre>';
                        // print_r($voice_note_audio_files);
                        // exit();

                        $model->UUID = $UUID;
                        $model->BranchID = $call_request_branch;
                        $model->EnteredOn = date('Y-m-d H:i:s');
                        $model->EnteredBy = 1;

                        //$transaction2 = Yii::$app->contact_db->beginTransaction();
                        //try {
                        if ($model->save()) {
                            $CompletedTime = date('Y-m-d H:i:s');
                            $Tried = 1;
                            $job_message = 'Executed Successfully';
                            $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", job_message = "' . $job_message . '", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';
                            Yii::$app->machine_db->createCommand($update_status)->execute();
                            Yii::$app->contact_db->createCommand('update job_packet_dtl set Responce = "Y", Redial = "'.$action.'" where ID =' . $JobID)->execute();

//                            Yii::$app->contact_db->createCommand('update contact_number_list set Response = "Y" where ID =' . $ContactID)->execute();
                            //$transaction2->commit();
                        } else {
                            print_r($model->getErrors());
                            exit();
                        }


//                        } catch (Exception $e) {
//                            $transaction2->rollback();
//                        }
                    } else {
                        $job_message = 'UUID Already Added';
                        $CompletedTime = date('Y-m-d H:i:s');
                        $update_msg = 'update node_requested_date set status = 1, Completed = 1,  PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", job_message = "' . $job_message . '"  where ID = "' . $row_id . '" and UUID = "' . $UUID . '"';
                        Yii::$app->machine_db->createCommand($update_msg)->execute();
                    }


                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
            }


            $pkt_ids = implode(',', $packets_arr);
            if(!empty($pkt_ids)){

                Yii::$app->contact_db->createCommand("update employee_job_packet_dtl jd set jd.CalledNo = (select COUNT(b.ID) from job_packet_dtl b where jd.PacketID = b.PacketID and b.Responce = 'Y') WHERE jd.PacketID in ($pkt_ids)")->execute();
                Yii::$app->contact_db->createCommand("update employee_job_packet_dtl jd set Status = 1 WHERE PacketCount = CalledNo and PacketID in ($pkt_ids)")->execute();
            }
            //echo '--' . $pkt_ids;

            echo 'Job Done';

            exit();
        } else {
            echo 'No Data Found';
            exit();
        }


    }

}