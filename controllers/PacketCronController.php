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

use app\models\NodeRequestedDate;
use app\models\JobCallResponses;
use app\models\UserMobileInfo;
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
        // "ABC":{"0":"VoiceNote1.aac","1":"VoiceNote2.aac","2":"VoiceNote3.aac"}}]';

        $model_req = new JobCallResponses();
       
       $call_record = NodeRequestedDate::find()->all();

       foreach ($call_record as $value) {
           
       

       $requested_data = $value->DataPacket;

       $data = json_decode($requested_data);



       foreach ($data as $key => $val)
       {
        $macAddress = $val->MacAddress;
        $UserID = $val->UserID;
        $JobID = $val->JobID;
        $CompanyID = $val->CompanyID;
        $ContactID = $val->ContactID;
        $ResponseValues = $val->ResponseValues;
        $ProfileInfo = $val->ProfileInfo;
        $VoiceCall = $val->VoiceCall;
        $OtherNotes = $val->OtherNotes;
       }
       
        $model_req->MacInfo = $macAddress;
        $model_req->ContactID = $ContactID;
        $model_req->ResponseID = $ResponseValues;
        $model_req->UserID = $UserID;
        $model_req->CallFilePath = $VoiceCall;
        $model_req->OtherNote = $OtherNotes;
        $model_req->PacketDtlID = $JobID;

        $packet_record = JobPackets::find()->where(['ID' => $JobID])->one();
        $packet_data = $packet_record->ID;

        $model_req->JobPacketID = $packet_data;
        $model_req->AudioNote = 'safdsa';

        $model_req->BranchID = $packet_record->BranchID;
        $model_req->EnteredOn = date('Y-m-d H:i:s');
        $model_req->EnteredBy = 1;

        
      if($model_req->save()) {

      }else{
        print_r($model_req->getErrors());exit();
      }

            // if($model_req->save()) {
            //     $responce = array("Code"=>200,"message"=>"Save Sucessfully");
            // }else{
            //     $responce = array("Code"=>203,"message"=>"Not posted Properly");
            // }
        }
        echo $responce;exit();

        
    }
    
    }