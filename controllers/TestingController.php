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
class TestingController extends Controller
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
        if ($action->id == 'call' || $action->id == 'postman' || $action->id == 'responseoptions') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * To get the response against a EmpID in mobile info table.
     */
    
   public function actionResponseOption($id=0,$branch_id=0)
   {

         if($id == 0) {
             // $api_data_streem = file_get_contents("php://input");
             $api_data_streem = '[{"EmpID":"7","BranchID":"2"}]';

             $data = json_decode($api_data_streem);
             foreach ($data as $v) {
                 $type = $v->EmpID;
                 $branch_id = $v->BranchID;
             }

         }else{
             $type = $id;
             $branch_id = $branch_id;
         }

               if(!empty($type)){
                   $resp_msg = '';
                   unset($master_array);
                   $user_type_rec = UserMobileInfo::find()->where(['EmpID' => $type])->andWhere(['BranchID'=>$branch_id])->andWhere(AppConstants::get_active_record_only)->all();

                   if(!empty($user_type_rec)){

                       foreach($user_type_rec as $v) {
                           $user_type_detail = AppResponseDtl::find()->where(['ResponseHeadID' => $v->UserType])->andWhere(['BranchID' => $branch_id])->andWhere(AppConstants::get_active_record_only)->all();
                           if (!empty($user_type_detail)) {
                               unset($val_arr);
                               foreach ($user_type_detail as $val) {
                                   $val_arr[] = array('value' => $val->ID, 'valueText' => $val->OptionText);
                               }
                           }
                           $master_array[] = array('Headings'=>$v->ID,'InputType'=>$val->InputType,'OptionValue' => $val_arr);
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
