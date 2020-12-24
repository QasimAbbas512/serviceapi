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
use app\models\Employees;
use app\models\User;
use app\models\UserMobileInfo;
use app\models\ContactNumberList;
use app\models\JobCallResponses;
use app\models\AppResponse;
use app\models\AppResponseDtl;
use app\models\EmployeesSearch;
use CommonFunctions;
use AppConstants;
use GetParams;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use linslin\yii2\curl;

class LoginController extends Controller
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
        if ($action->id == 'call' || $action->id == 'verify' || $action->id == 'number-list' || $action->id == 'contact-details') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * cURL GET example
     */

    public function actionCnic()
    {
        $CNIC = $_REQUEST['cnic'];

        // $CNIC = '37405-4903238-2';
        $employee_list = Employees::find()->where(['CNIC' => $CNIC])->one();

        $employee = array('name' => $employee_list->FullName, 'Cell' => $employee_list->CellNo, 'Address' => $employee_list->Address, 'CNIC' => $employee_list->CNIC, 'Email' => $employee_list->Email);

        $returnVal = json_encode($employee);
        return $returnVal;
    }

    public function actionVerify()
    {
        $api_data_streem = file_get_contents("php://input");
//        $api_data_streem = '[{  "username":"laiba@aaa.com",
//                                 "pass":"laiba123",
//                                 "EMEI":"E34534dfgd"}]';
        $data = json_decode($api_data_streem);

        if (!empty($data)) {
//            foreach ($data as $v) {
//                $user = $v->username;
//                $pass = $v->pass;
//                $emei_no = $v->EMEI;
//            }
            $user = $data->username;
            $pass = $data->pass;
            $emei_no = $data->EMEI;
            $user_record = User::find()->where(['UserName' => $user])->andWhere(['PasswordKey' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
            if (!empty($user_record)) {
                $emp_id = $user_record->EmpID;

                $employee_info = CommonFunctions::selectEmployeeInfo($emp_id,$user_record->BranchID);

                $emp_name = CommonFunctions::printEmployeeName($user_record->EmpID,$user_record->BranchID);
                $emp_gender = CommonFunctions::printGender($employee_info->Gender);
                $emp_dep = CommonFunctions::printDepartment($employee_info->DepartmentID,$user_record->BranchID);
                $emp_desgination = CommonFunctions::printDesignation($employee_info->DesignationID,$user_record->BranchID);
                $emp_branch = CommonFunctions::selectCompanyBranchInfo($user_record->BranchID);
                $responce_message = array('Code' => '200', 'message' => 'Login Successful');
               // $responce_data = array('UserID' => $user_record->id, 'BranchID' => $user_record->BranchID, 'EmployeeID' => $user_record->EmpID, 'EmpName' => $emp_name, 'DOB' => $employee_info->DateOfBirth, 'Gender' => $emp_gender, 'Designation' => $emp_desgination, 'Department' => $emp_dep, 'OfficeBranch' => $emp_branch->BranchName);

                $emei_valid_aray = '';
                if (!empty($emei_no)) {
                    $user_device_record = UserMobileInfo::find()->where(['EmpID' => $user_record->EmpID])->andWhere(['BranchID' => $user_record->BranchID])->andWhere(['DeviceMac' => $emei_no])->andWhere(AppConstants::get_active_record_only)->one();
                    if (!empty($user_device_record)) {
                        $resp_msg = 'Y';
                        $user_type = CommonFunctions::printListValue($user_device_record->UserType);

                        $user_type_rec = AppResponse::find()->where(['AppUserType' => $user_device_record->UserType])->andWhere(['BranchID'=>$user_device_record->BranchID])->andWhere(AppConstants::get_active_record_only)->all();
                        if(!empty($user_type_rec)){
                            foreach($user_type_rec as $v) {
                                $user_type_detail = AppResponseDtl::find()->where(['ResponseHeadID' => $v->ID])->andWhere(['BranchID' => $user_device_record->BranchID])->andWhere(AppConstants::get_active_record_only)->all();

                                if (!empty($user_type_detail)) {
                                    unset($val_arr);
                                    foreach ($user_type_detail as $val) {
                                        $val_arr[] = array('value' => $val->ID, 'valueText' => $val->OptionText);
                                    }
                                }
                                $master_array[] = array('OptionValue' => $val_arr);
                                $resp_vals = $master_array;
                            }
                            $heading = $v->ResponceHeading;
                            $input_type = $v->InputType;
                            $resp_vals = $val_arr;
                        }

                        $responce_data = array('UserType'=>$user_type,'UserID' => $user_record->id, 'BranchID' => $user_record->BranchID, 'EmployeeID' => $user_record->EmpID, 'EmpName' => $emp_name,'DOB' => $employee_info->DateOfBirth, 'Gender' => $emp_gender, 'Designation' => $emp_desgination, 'Department' => $emp_dep, 'OfficeBranch' => $emp_branch->BranchName,'Headings'=>$heading,'InputTypes'=>$input_type,'Values'=>$val_arr);
                        $responce = array('message' => $responce_message,'data'=>$responce_data);
                        if(empty($resp_vals) || empty($heading)){
                            $responce_message = array('Code' => '403', 'message' => 'Login verified But Data Options Not Available');
                            $responce = array('message' => $responce_message,'data'=>$responce_data);
                        }
                        //$responce = array('message' => $responce_message,'data'=>$responce_data,'responce_option'=>$response_options);
                    } else {
                        $resp_msg = 'Device is not registered. Please contact Administrator';
                        $responce_message = array('Code' => '403', 'message' => 'Login successful but device not registered');
                        $responce = array('message' => $responce_message);
                    }
                    $emei_valid_aray = array('EMEI_Validation' => $resp_msg);
                }

                $returnVal = json_encode($responce);


            } else {
                $responce_message = array('Code' => '403', 'message' => 'User name or password not valid');
                $responce = array('message' => $responce_message);
                $returnVal = json_encode($responce);

            }
            return $returnVal;
        }
    }

    public function actionClientLogin()
    {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];

        // $CNIC = '37405-4903238-2';
        $client_info = ClientInfo::find()->where(['UserName' => $user])->andWhere(['Password' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $resp = array('name' => $client_info->FirstName, 'LastName' => $client_info->LastName, 'Cnic' => $client_info->Cnic, 'UserName' => $client_info->UserName);
        $reponce = $resp;
        $xyzs = array($reponce);
        // $reponce = '[{"member_link":"1","guest_link":"2"}]';
        $res = array('client' => $xyzs);
        return json_encode($res);
    }

    public function actionNumberList()
    {
        $api_data_streem = file_get_contents("php://input");

        //$api_data_streem = '{  "EmployeeID":"183","BranchID":"2"}';

        $data = json_decode($api_data_streem);

        if (!empty($data)) {
//            foreach ($data as $v) {
//
//                $employee_id = $v->EmployeeID;
//            }
            $employee_id = $data->EmployeeID;
            $branch_id = $data->BranchID;

            $employee_list = Yii::$app->contact_db->createCommand("SELECT jp.PacketID,jp.ContactID,cl.ContactName, jp.ContactNumber,jp.ContactNotes
                                                                    FROM job_packet_dtl jp, employee_job_packet_dtl ejp, contact_number_list cl
                                                                    WHERE ejp.PacketID = jp.PacketID and jp.ContactID = cl.ID and ejp.EmployeeID = '" . $employee_id . "' and ejp.BranchID = jp.BranchID and ejp.Status = 0 ")->queryAll();

            if (!empty($employee_list)) {
                $employee_list = CommonFunctions::arrayToObject($employee_list);
                $x = 0;
                foreach ($employee_list as $v) {
                    $x++;
                    if(!empty($v->ContactName)){
                        $conatct_name = $v->ContactName;
                    }else{
                        $conatct_name = 'No Name';
                    }
                    $contact_id = $v->ContactID;
//                    $conatc_info = ContactNumberList::find()->where(['ID'=>$contact_id])->one();
//                    $call_history_info = Yii::$app->contact_db->createCommand("SELECT CallFilePath,ResponseID,OtherNote,AudioNote,UserID,EnteredOn FROM job_call_responses WHERE ContactID =".$contact_id)->queryAll();
//                    $call_history_info = CommonFunctions::arrayToObject($call_history_info);
//
//                    unset($call_responses);
//                    if (!empty($call_history_info)) {
//
//                        foreach ($call_history_info as $call_dtl) {
//                            $responce_info = CommonFunctions::printResponcseName($call_dtl->ResponseID);
//                            $call_by_info = CommonFunctions::printEmployeeName($call_dtl->UserID,$branch_id);
//                            $call_on = date('d M, Y',strtotime($call_dtl->EnteredOn));
//                            $call_responses[] = array('CallRecording' => $call_dtl->CallFilePath, 'AudioNote' => $call_dtl->AudioNote, 'OtherNote' => $call_dtl->OtherNote,'ResponceNote'=>$responce_info,'CallBy'=>$call_by_info,'CallDate'=>$call_on);
//                        }
//
//
//                        //$history_data = array('ContactInfo'=>$contact_dtl,'CallHistory' => $call_responses);
//                    }
                    //$number_list[] = array('ContactID'=>$v->ContactID,'ContactNumber' => $v->ContactNumber, 'ContactName'=>$conatct_name,'ContactNotes' => $v->ContactNotes,'CallHistory' => $call_responses);
                    $number_list[] = array('ContactID'=>$contact_id,'ContactNumber' => $v->ContactNumber, 'ContactName'=>$conatct_name,'ContactNotes' => $v->ContactNotes);
                }

                $responce_message = array('Code' => '200', 'message' => 'Packet Fetched!');
                $data_pkt = $number_list;
                //$data_pkt = array('data' => $number_list);
            } else {
                $responce_message = array('Code' => '403', 'message' => 'Packet Not Fetched!');
                $data_pkt = array("");
                $responce = array('message' => $responce_message);

            }

            $responce = array('message' => $responce_message, 'data' => $data_pkt);
            $returnVal = json_encode($responce);
//            echo '<pre>';
//            print_r($responce);
//            exit();
            return $returnVal;
        }

    }

    public function actionContactDetails()
    {
        $api_data_streem = file_get_contents("php://input");

//        $api_data_streem = '[{  "contact_id":"5",
//                                 "BranchID":"2",
//                                 "user_id":"116"}]';

        $data = json_decode($api_data_streem);

        if (!empty($data)) {
//            echo '<pre>';
//            print_r($data);
//            exit();
//            foreach ($data as $v) {
//                $contact_id = $v->contact_id;
//                $BranchID = $v->BranchID;
//                $user_id = $v->user_id;
//            }
            $contact_id = $data->contact_id;
            $BranchID = $data->BranchID;
            $user_id = $data->user_id;

            $conatc_info = ContactNumberList::find()->where(['ID'=>$contact_id])->one();
            if(!empty($conatc_info)){
                $contact_id = $conatc_info->ID;
                $conatc_name = $conatc_info->ContactName;
                $conatc_address = $conatc_info->ContactAddress;
                $conatc_notes = $conatc_info->ContactNotes;
            }else{
                $conatc_name = $conatc_info->ContactName;
                $conatc_address = $conatc_info->ContactAddress;
                $conatc_notes = $conatc_info->ContactNotes;
            }
            $contact_dtl = array('ID'=>$contact_id,'ContactName'=>$conatc_name,'Address'=>$conatc_address,'Notes'=>$conatc_notes);

            $call_history_info = Yii::$app->contact_db->createCommand("SELECT CallFilePath,ResponseID,OtherNote,AudioNote,UserID,EnteredOn FROM job_call_responses WHERE ContactID =".$contact_id)->queryAll();
            $call_history_info = CommonFunctions::arrayToObject($call_history_info);

            $call_history_info = JobCallResponses::find()->select('CallFilePath,ResponseID,OtherNote,AudioNote,UserID,EnteredOn')->where(['ContactID'=>$contact_id])->all();

            if (!empty($call_history_info)) {


                foreach ($call_history_info as $v) {
                    $responce_info = CommonFunctions::printResponcseName($v->ResponseID);
                    $call_by_info = CommonFunctions::printEmployeeName($v->UserID,$BranchID);
                    $call_on = date('d M, Y',strtotime($v->EnteredOn));
                    $call_responses[] = array('CallRecording' => $v->CallFilePath, 'AudioNote' => $v->AudioNote, 'OtherNote' => $v->OtherNote,'ResponceNote'=>$responce_info,'CallBy'=>$call_by_info,'CallDate'=>$call_on);
                }

                $responce_message = array('Code' => '200', 'message' => 'Data Fetched!');
                $history_data = array('ContactInfo'=>$contact_dtl,'CallHistory' => $call_responses);
            } else {
                $responce_message = array('Code' => '403', 'message' => 'Response Not Fetched!');
                $history_data = '';
                $responce = array('message' => $responce_message);

            }

            $responce = array('message' => $responce_message, 'data' => $history_data);
            $returnVal = json_encode($responce);

            return $returnVal;
        }

    }

}