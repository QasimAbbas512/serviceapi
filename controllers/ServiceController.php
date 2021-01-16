<?php

namespace app\controllers;

use Yii;
use app\models\UserMobileInfo;
use app\models\AppResponse;
use app\models\AppResponseDtl;
use app\models\User;
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



    public function actionUpload()
    {

        $target_path = "files/";//"uploads/";

// array for final json respone
        $response = array();

// getting server ip address
        $server_ip = gethostbyname(gethostname());

// final file url that is being uploaded
        //$file_upload_url = 'http://' . $server_ip . '/' . 'AndroidFileUpload' . '/' . $target_path;
        $file_upload_url = Yii::$app->request->baseUrl.'/files/';

        if (isset($_FILES['image']['name'])) {
            $target_path = $target_path . basename($_FILES['image']['name']);
            $files = UploadedFile::getInstancesByName($_FILES['image']['name']);
            $x = '0';
            // reading other post parameters
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $website = isset($_POST['website']) ? $_POST['website'] : '';

            $response['file_name'] = basename($_FILES['image']['name']);

            try {
                // Throws exception incase file is not being moved
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    // make error flag true
                    $response['error'] = true;
                    $response['message'] = 'Could not move the file!';
                }

                // File successfully uploaded
                $response['message'] = 'File uploaded successfully!';
                $response['error'] = false;
                $response['file_path'] = $file_upload_url . basename($_FILES['image']['name']);
            } catch (Exception $e) {
                // Exception occurred. Make error flag true
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
        } else {
            // File parameter is missing
            $response['error'] = true;
            $response['message'] = 'Not received any file!F';
        }

// Echo final json response to client
        echo '<pre>';
        print_r($response);
        exit();
        echo json_encode($response);

    }

    /**
     * Lists all Employees models.
     * @return mixed
     */
    public function beforeAction($action)
    {
        if ($action->id == 'response-options' || $action->id == 'post-dialer-response' || $action->id == 'change-pin' || $action->id == 'dialer-response-multiple' || $action->id == 'upload') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * To get the response against a UserType in mobile info table.
     */

    public function actionResponseOptions($id = 0, $branch_id = 0)
    {


        if ($id == 0) {
            // $api_data_streem = file_get_contents("php://input");
            $api_data_streem = '[{"UserType":"29","BranchID":"1"}]';

            $data = json_decode($api_data_streem);
            foreach ($data as $v) {
                $type = $v->UserType;
                $branch_id = $v->BranchID;
            }

        } else {
            $type = $id;
            $branch_id = $branch_id;
        }

        if (!empty($type)) {
            $resp_msg = '';
            unset($master_array);
            $user_type_rec = AppResponse::find()->where(['AppUserType' => $type])->andWhere(['BranchID' => $branch_id])->andWhere(AppConstants::get_active_record_only)->all();

            if (!empty($user_type_rec)) {

                foreach ($user_type_rec as $v) {
                    $user_type_detail = AppResponseDtl::find()->where(['ResponseHeadID' => $v->ID])->andWhere(['BranchID' => $branch_id])->andWhere(AppConstants::get_active_record_only)->all();

                    if (!empty($user_type_detail)) {
                        unset($val_arr);
                        foreach ($user_type_detail as $val) {
                            $val_arr[] = array('value' => $val->ID, 'valueText' => $val->OptionText);
                        }
                    }
                    $master_array[] = array('Headings' => $v->ResponceHeading, 'InputType' => $v->InputType, 'OptionValue' => $val_arr);
                    $resp_msg = array('headingInfo' => $master_array);
                }

                $returnVal = $resp_msg;
                return $returnVal;
            } else {
                $resp_msg = 'No Response Against This User Type.';
                $responce = array('Error' => $resp_msg);
                $returnVal = $responce;
                return $returnVal;
            }
            //$responce = array('User Type is Valid, Requested Details:' => $resp_msg);
        } else {
            $responce = array('Code:' => '203', 'message' => 'No data passed');
            $returnVal = json_encode($responce);
            return $returnVal;
        }


    }

    public function actionDialerResponseMultiple()
    {

        $posting_data = file_get_contents("php://input");
//       $posting_data = '{"UUID":"0-WSD3:9l:440:45-1235688965","EmployeeID":"183","BranchID":"2","DateTime":"2021-01-05 16:25","Data":[{"UUID":"1-WSD3:9l:440:45-1235688965","MacAddress":"WSD3:9l:440:45",
//         "UserID":"1",
//         "JobID":"1",
//         "CompanyID":"1",
//         "ContactID":"5",
//         "ResponseValues":"3",
//         "ProfileInfo":"Address location area etc",
//         "VoiceCall":"CallFileName.aac",
//         "OtherNotes":"text notes",
//         "AudioNotes":"audio.mp3"},
//         {"UUID":"2-WSD3:9l:440:45-1235688965","MacAddress":"WSD3:9l:440:45",
//         "UserID":"1",
//         "JobID":"1",
//         "CompanyID":"1",
//         "ContactID":"5",
//         "ResponseValues":"3",
//         "ProfileInfo":"Address location area etc",
//         "VoiceCall":"CallFileName.aac",
//         "OtherNotes":"text notes",
//         "AudioNotes":"audio.mp3"},
//         {"UUID":"3-WSD3:9l:440:45-1235688965","MacAddress":"WSD3:9l:440:45",
//         "UserID":"1",
//         "JobID":"1",
//         "CompanyID":"1",
//         "ContactID":"5",
//         "ResponseValues":"3",
//         "ProfileInfo":"Address location area etc",
//         "VoiceCall":"CallFileName.aac",
//         "OtherNotes":"text notes",
//         "AudioNotes":"audio.mp3"}]
//         }';

        $data = json_decode($posting_data);

        $uuid = $data->UUID;
        $responce_action = 'call_response_multiple';

        $response = CommonFunctions::SaveNodes($responce_action, $posting_data, $uuid);
        if ($response == 1) {
            $message = array('Code' => '200', 'message' => 'Sucessfully Saved.');
        } else if ($response == 2) {
            $message = array('Code' => '403', 'message' => 'Request Against UUID Already Sent.');
        } else {
            $message = array('Code' => '403', 'message' => 'Not Saved.');
        }

        $response_array = array('Message' => $message);
        $response = json_encode($response_array);

        return $response;
    }

    public function actionPostDialerResponse()
    {

        $posting_data = file_get_contents("php://input");
//       $posting_data = '[{"UUID":"WSD3:9l:440:45-1235688965","MacAddress":"WSD3:9l:440:45",
//         "UserID":"1",
//         "JobID":"1",
//         "CompanyID":"1",
//         "ContactID":"5",
//         "ResponseValues":"3",
//         "ProfileInfo":"Address location area etc",
//         "VoiceCall":"CallFileName.aac",
//         "OtherNotes":"text notes",
//         "AudioNotes":{"0":"VoiceNote1.aac","1":"VoiceNote2.aac","2":"VoiceNote3.aac"}}]';

        $data = json_decode($posting_data);

//        foreach($data as $k=>$v){
//            $uuid = $v->UUID;
//        }
        $uuid = $data->UUID;
        $responce_action = 'call_response';

        $response = CommonFunctions::SaveNodes($responce_action, $posting_data, $uuid);
        if ($response == 1) {
            $message = array('Code' => '200', 'message' => 'Sucessfully Saved.');
        } else if ($response == 2) {
            $message = array('Code' => '403', 'message' => 'Request Against UUID Already Sent.');
        } else {
            $message = array('Code' => '403', 'message' => 'Not Saved.');
        }

        $response_array = array('Message' => $message);
        $response = json_encode($response_array);

        return $response;
    }

    public function actionSort()
    {
        $nm = $_REQUEST['table'];
        $limit = $_REQUEST['limit'];
        if (empty($nm)) {
            $field_work_for = 'Contact1';
        } else {
            $field_work_for = 'Contact' . $nm;
        }
        if (empty($limit)) {
            $limit = 1000;
        }

        Yii::$app->faiz->createCommand("update faiz_data set status = 'Y' where " . $field_work_for . " = ''")->execute();
        Yii::$app->faiz->createCommand("update faiz_data set status = 'Y' where " . $field_work_for . " = 0")->execute();
        Yii::$app->faiz->createCommand("update faiz_data set status = 'Y' where " . $field_work_for . " = 'Null'")->execute();
        $rst = Yii::$app->faiz->createCommand("select distinct(" . $field_work_for . ") from faiz_data where status = 'N' limit 2")->queryAll();
        //$rst = CommonFunctions::arrayToObject($rst);
//       echo '<pre>';
//       print_r($rst);
//       exit();
        if (!empty($rst) && count($rst) > 0) {
            foreach ($rst as $v) {
                // echo $v->File.'-'.$v->Name.'-'.$v->Contact1.'<br>';
                $contact_no = $v['Contact' . $nm];
                $chk_number = Yii::$app->faiz->createCommand("select * from faiz_data where " . $field_work_for . " =  '$contact_no' order by id ASC limit 1")->queryAll();
                $chk_number = CommonFunctions::arrayToObject($chk_number);
                if (!empty($chk_number)) {
                    foreach ($chk_number as $val) {
                        $current_id = $val->id;
                        Yii::$app->faiz->createCommand("update faiz_data set " . $field_work_for . " = NULL where id !=" . $current_id . " and " . $field_work_for . " = '$contact_no'")->execute();
                        //echo "update faiz_data set " . $field_work_for . " = NULL where id !=" . $current_id . " and " . $field_work_for . " = '$contact_no'<br>";
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i != $nm) {
                                //echo "update faiz_data set Contact".$i." = NULL where Contact".$i." = '$contact_no'<br>";
                                Yii::$app->faiz->createCommand("update faiz_data set Contact2 = NULL where Contact2 = '$contact_no'")->execute();
                            }
                        }


                        Yii::$app->faiz->createCommand("update faiz_data set status = 'Y' where id =" . $current_id)->execute();
                        // echo $current_id.'-'.$v->File.'-'.$v->Name.'-'.$v->Contact1.'<br>';
                        // exit();
                    }
                }


            }
            echo $limit . ' Records Done For ' . $field_work_for;
            header("Refresh: 2;");
        } else {
            echo $field_work_for . ' column is finished';
        }
    }

    public function actionChangePin()
    {
        $api_data_streem = file_get_contents("php://input");
//        $api_data_streem = '{  "UserID":"160",
//                                 "OldPin":"qasim123",
//                                 "NewKey":"qasim123456"}';
        $data = json_decode($api_data_streem);

        if (!empty($data)) {

            $user_id = $data->UserID;
            $old_pass = $data->OldPin;
            $new_key = $data->NewKey;
            //echo $user_id.'-'.$old_pass.'-'.$new_key;exit();
            $user_record = User::find()->where(['EmpID' => $user_id])->andWhere(['PasswordKey' => $old_pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
            if (!empty($user_record)) {

                Yii::$app->db->createCommand("update user set PasswordKey = '" . $new_key . "' where EmpID =" . $user_id)->execute();
                $responce_message = array('Code' => '200', 'message' => 'New Password Updated');
                $responce = array('message' => $responce_message);
                $returnVal = json_encode($responce);


            } else {
                $responce_message = array('Code' => '403', 'message' => 'Old password not valid');
                $responce = array('message' => $responce_message);
                $returnVal = json_encode($responce);

            }
            return $returnVal;
        }
    }

}
