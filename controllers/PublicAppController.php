<?php

namespace app\controllers;


use app\models\ClientInfo;
use app\models\ClientInvestment;
use app\models\Projects;
use Yii;
use yii\web\Controller;
use app\models\Employees;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use CommonFunctions;
use AppConstants;

class PublicAppController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()
    {
        //return $this->render('index');
    }

    public function actionMobileAppUrls()
    {

        $token = $_REQUEST['token'];
        $token_match_val = AppConstants::android_public_app_token;
        $member_link = AppConstants::android_public_app_member_url;
        $guest_link = AppConstants::android_public_app_guest_url;
        if(!empty($token) && $token == $token_match_val) {

            $resp = array("member_link" => $member_link, "guest_link" => $guest_link);//"Code" => 200, "msg" => "Successfully Executed",
            $reponce = $resp;//json_encode($resp);
        }else{

            $resp = array("Code" => 503, "msg" => "Please send valid token");
            $reponce = $resp;//json_encode($resp);
        }
       
        $xyzs = array($reponce);
        // $reponce = '[{"member_link":"1","guest_link":"2"}]';
//        {"client":[{"name":"junaid","LastName":"mehmood","Cnic":"1234567890","UserName":"jmehmood"}]}
        $res = array('links'=>$xyzs);

        return $res;
    }


    public function actionClientLogin()
    {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];

        // $CNIC = '37405-4903238-2';
        $client_info = ClientInfo::find()->where(['UserName' => $user])->andWhere(['Password' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $client_id = $client_info->ID;
        $investment_info = ClientInvestment::find()->where(['ClientID' => $client_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $project_id = $investment_info->ProjectID;
        $project_info = Projects::find()->where(['ID'=> $project_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $resp = array("name"=>$client_info->FirstName, "LastName"=>$client_info->LastName, "Cnic"=>$client_info->Cnic, "MemberID"=>$client_info->UserName, "Project"=>$project_info->ProjectName, "ContractValidity"=>$investment_info->ContractExpiryDate);
        $reponce = $resp;
        $xyzs = array($reponce);
//        $abc= json_encode($xyzs);
//        echo '<pre>';
//        print_r(json_decode($abc));exit();
        // $reponce = '[{"member_link":"1","guest_link":"2"}]';
        $res = array('client'=>$xyzs);
        return $res;
    }

    public function actionClient()
    {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];

        // $CNIC = '37405-4903238-2';
        $client_info = ClientInfo::find()->where(['UserName' => $user])->andWhere(['Password' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $resp = array("id"=>$client_info->ID);
        $reponce = $resp;
        $xyzs = array($reponce);
//        $abc= json_encode($xyzs);
//        echo '<pre>';
//        print_r(json_decode($abc));exit();
        // $reponce = '[{"member_link":"1","guest_link":"2"}]';
        $res = array('client'=>$xyzs);
        return $res;
    }
}