<?php

namespace app\controllers;

use Yii;
use app\models\Employees;
use app\models\User;
use app\models\UserMobileInfo;
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
     * cURL GET example
     */
    
   public function actionResponseOptions($id=0,$branch_id=0)
   {
       // $api_data_streem = file_get_contents("php://input");
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


//           $user_type_record = UserMobileInfo::find()->where(['UserType' => $type])->andWhere(['Active'=>'Y'])->andWhere(AppConstants::get_active_record_only)->one();
//           if (!empty($user_type_record)) {

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
                           $master_array[] = array('Headings'=>$v->ID,'InputType'=>$v->InputType,'OptionValue' => $val_arr);
                           $resp_msg = array('headingInfo'=>$master_array);
                       }

                       $returnVal = json_encode($resp_msg);
                       return $returnVal;
                   }else{
                       $resp_msg = 'No Response Against This User Type.';
                       $responce = array('Error' => $resp_msg );
                       $returnVal = json_encode($responce);
                        return $returnVal;
                   }
                   //$responce = array('User Type is Valid, Requested Details:' => $resp_msg);
               }else{
                   $responce = array('Code:' => '203','message'=>'No data passed');
                   $returnVal = json_encode($responce);
                   return $returnVal;
                    }



   }


}
