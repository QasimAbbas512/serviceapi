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
        if ($action->id == 'call' || $action->id == 'postman') {
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
	
    $employee= array('name' => $employee_list->FullName,'Cell' =>$employee_list->CellNo,'Address' =>$employee_list->Address,'CNIC' =>$employee_list->CNIC,'Email' =>$employee_list->Email);
    
         $returnVal = json_encode($employee);
           return $returnVal;
    }


   public function actionPostman()
   {
       //$api_data_streem = file_get_contents("php://input");

          $api_data_streem = '[{  "username":"admin",
                                 "pass":"admin123",
                                 "EMEI":"msxnjsxdhuh7677mmnk"}]';

       $data = json_decode($api_data_streem);
       if(!empty($data)) {
           foreach ($data as $v) {

               $user = $v->username;
               $pass = $v->pass;
               $emei_no = $v->EMEI;
           }

           $user_record = User::find()->where(['UserName' => $user])->andWhere(['PasswordKey' => $pass])->andWhere(['Active'=>'Y'])->andWhere(AppConstants::get_active_record_only)->one();
           if (!empty($user_record)) {
               $emp_name = 'ABC';//CommonFunctions::printEmployeeName($user_record->EmpID,$user_record->BranchID);
               $responce_message = array('Code' => '200', 'message' => 'Login Sucessful');
               $responce_data = array('UserID'=>$user_record->id,'BranchID'=>$user_record->BranchID,'EmployeeID'=>$user_record->EmpID,'EmpName'=>$emp_name);
               $responce = array('message'=>$responce_message,'date'=>$responce_data);
               $emei_valid_aray = '';
               if(!empty($emei_no)){
                   $user_device_record = UserMobileInfo::find()->where(['EmpID' => $user_record->EmpID])->andWhere(['BranchID' => $user_record->BranchID])->andWhere(['DeviceMac'=>$emei_no])->andWhere(AppConstants::get_active_record_only)->one();
                   if(!empty($user_device_record)){
                    $resp_msg ='Y';
                       $response_options = Yii::$app->runAction('service/response-options', ['id' => $user_device_record->UserType, 'branch_id'=>$user_device_record->BranchID]);
                   }else{
                       $resp_msg = 'Device is not registered. Please contact Administrator';
                       $response_options = '';
                   }
                   $emei_valid_aray = array('EMEI_Validation'=>$resp_msg);
               }

               $responce = array('message'=>$responce_message,'date'=>$responce_data,'emei_validation'=>$emei_valid_aray,'ResponseOptions'=>$response_options);
               $returnVal = json_encode($responce);
               echo '<pre>';
               print_r($responce);
               exit();
               return $returnVal;
           }
       }else{
           $responce = array('Code' => '403', 'message' => 'User name or password not valid');
           $returnVal = json_encode($responce);
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

    
    }