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

        $client_info = ClientInfo::find()->where(['UserName' => $user])->andWhere(['Password' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        if(!empty($client_info)) {
            $client_id = $client_info->ID;
            $investment_info = ClientInvestment::find()->where(['ClientID' => $client_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
            $project_id = $investment_info->ProjectID;
            $project_info = Projects::find()->where(['ID' => $project_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();

            for ($i = 1; $i <= 3; $i++) {
                $projects[] = array("Project" => $project_info->ProjectName . '-' . $i, "ContractValidity" => $investment_info->ContractExpiryDate . '-' . $i, "TotalInvestment" => 10000000, "MonthlyInsentive" => 100000, "TillDateAmountIncentive" => 400000, "Recieved" => 300000, "Balance" => 100000);
            }

            $client_profile_img = "http://aaacrm.net/cms/web/emp_images/202011241545245XUgrsa.jpg";
            $company_profile_img = "http://aaacrm.net/cms/web/logo_image/20200827170716aaa_logo.png";

            $clientProfile = array("name" => $client_info->FirstName, "LastName" => $client_info->LastName, "Cnic" => $client_info->Cnic, "MemberID" => "AAA-587", "ProfileImg" => $client_profile_img);
            $companyProfile = array("CompanyName" => "AAA Associates", "WhatsAppNo" => "090078601", "Support" => "+9286989768768", "logo" => $company_profile_img);

            //$res = array("client" => $clientProfile, "investments" => $projects, "CompanyProfile" => $companyProfile);
            $res = array("client" => array($clientProfile),"CompanyProfile" => array($companyProfile),"investments" => $projects);
        }else{
            $res = array("exception" => "Invelid user or password");
        }

        return $res;
    }


    public function actionClientLogin_x()
    {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];

        // $CNIC = '37405-4903238-2';
        $client_info = ClientInfo::find()->where(['UserName' => $user])->andWhere(['Password' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $client_id = $client_info->ID;
        $investment_info = ClientInvestment::find()->where(['ClientID' => $client_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $project_id = $investment_info->ProjectID;
        $project_info = Projects::find()->where(['ID'=> $project_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        $client_profile_img = "http://aaacrm.net/cms/web/emp_images/202011241545245XUgrsa.jpg";
        $resp = array("name"=>$client_info->FirstName, "LastName"=>$client_info->LastName, "Cnic"=>$client_info->Cnic, "MemberID"=>$client_info->UserName, "ProfileImg" => $client_profile_img, "Project"=>$project_info->ProjectName, "ContractValidity"=>$investment_info->ContractExpiryDate);
        $reponce = $resp;
        $xyzs = array($reponce);
//        $abc= json_encode($xyzs);
//        echo '<pre>';
//        print_r(json_decode($abc));exit();
        // $reponce = '[{"member_link":"1","guest_link":"2"}]';
        $res = array('client'=>$xyzs);
//        echo '<pre>';
//        print_r($res);
//        exit();
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