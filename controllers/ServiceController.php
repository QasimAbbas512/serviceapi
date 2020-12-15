<?php

namespace app\controllers;

use Yii;
use app\models\UserMobileInfo;
use app\models\AppResponse;
use app\models\AppResponseDtl;
use CommonFunctions;
use AppConstants;
use GetParams;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class ServiceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Employees models.
     * @return mixed
     */
    public function beforeAction($action)
    {
        if ($action->id == 'call' || $action->id == 'postman') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * To get the response against a UserType in mobile info table.
     */
    
   public function actionResponseOptions($id=0,$branch_id=0)
   {
       
       

         if($id == 0) {
             // $api_data_streem = file_get_contents("php://input");
             $api_data_streem = '[{"UserType":"29","BranchID":"1"}]';

             $data = json_decode($api_data_streem);
             foreach ($data as $v) {
                 $type = $v->UserType;
                 $branch_id = $v->BranchID;
             }

         }else{
             $type = $id;
             $branch_id = $branch_id;
         }

               if(!empty($type)){
                   $resp_msg = '';
                   unset($master_array);
                   $user_type_rec = AppResponse::find()->where(['AppUserType' => $type])->andWhere(['BranchID'=>$branch_id])->andWhere(AppConstants::get_active_record_only)->all();

                   if(!empty($user_type_rec)){

                       foreach($user_type_rec as $v) {
                           $user_type_detail = AppResponseDtl::find()->where(['ResponseHeadID' => $v->ID])->andWhere(['BranchID' => $branch_id])->andWhere(AppConstants::get_active_record_only)->all();

                           if (!empty($user_type_detail)) {
                               unset($val_arr);
                               foreach ($user_type_detail as $val) {
                                   $val_arr[] = array('value' => $val->ID, 'valueText' => $val->OptionText);
                               }
                           }
                           $master_array[] = array('Headings'=>$v->ResponceHeading,'InputType'=>$v->InputType,'OptionValue' => $val_arr);
                           $resp_msg = array('headingInfo'=>$master_array);
                       }

                       $returnVal = $resp_msg;
                       return $returnVal;
                   }else{
                       $resp_msg = 'No Response Against This User Type.';
                       $responce = array('Error' => $resp_msg );
                       $returnVal = $responce;
                        return $returnVal;
                   }
                   //$responce = array('User Type is Valid, Requested Details:' => $resp_msg);
               }else{
                   $responce = array('Code:' => '203','message'=>'No data passed');
                   $returnVal = json_encode($responce);
                   return $returnVal;
                    }



   }

   public function actionPostDialerResponse(){

       //$posting_data = file_get_contents("php://input");
       $posting_data = '[{"UUID":"WSD3:9l:440:45-1235688965","MacAddress":"WSD3:9l:440:45",
         "UserID":"1",
         "JobID":"1",
         "CompanyID":"1",
         "ContactID":"5",
         "ResponseValues":"3",
         "ProfileInfo":"Address location area etc",
         "VoiceCall":"CallFileName.aac",
         "OtherNotes":"text notes",
         "AudioNotes":{"0":"VoiceNote1.aac","1":"VoiceNote2.aac","2":"VoiceNote3.aac"}}]';

        $data = json_decode($posting_data);

        foreach($data as $k=>$v){
            $uuid = $v->UUID;
        }


       $responce_action = 'call_response';

       $response = CommonFunctions::SaveNodes($responce_action,$posting_data);
       if($response == 1){
           $message = array('Code' => '200', 'message' => 'Sucessfully Saved');
       }else{
           $message = array('Code' => '403', 'message' => 'Not Saved');
       }

       $response_array = array('Message'=>$message);
       $response = json_encode($response_array);

        return $response;
   }
}
