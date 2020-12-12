<?php

namespace app\controllers;


use app\models\ClientInfo;
use app\models\ClientInvestment;
use app\models\ProjectGallery;
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

    /**
     * @return array
     * following action will return active images of projects randomly for mobile screens only
     * these images should be very light weight.
     */
    public function actionAppSliderGallery()
    {
        $token_info = $_REQUEST['verifyme'];
        if($token_info == AppConstants::android_public_app_gallery_token) {
            $gallery_info = ProjectGallery::find()->where(['ImageFor'=>'android'])->andwhere(AppConstants::get_active_record_only)->groupBy('ProjectID')->orderBy(['rand()' => SORT_DESC])->limit(8)->all();
            //$gallery_info = ProjectGallery::find()->where(['ImageFor'=>'android'])->andwhere(AppConstants::get_active_record_only)->orderBy(['rand()' => SORT_DESC])->limit(7)->all();

            if (!empty($gallery_info)) {
                $res = '';
               // $gallry_images = '';
                $i=0;
                foreach ($gallery_info as $v) {
                    $i++;
                    $img_name = $v->ImageName;
                    $project_info = CommonFunctions::selectProjectInfo($v->ProjectID, $v->CompanyID);
                    $project_name = $project_info->ProjectName;
                    $caption = $project_info->Description;
                    $img_link = AppConstants::ProjectImgUrl . '/' . $img_name;
                    $project_name = $project_name;
                    $value_name = 'slider';

                    $gallry_images[] = array($value_name => $img_link, "ProjectName" => $project_name);
                }

                $res = array("ImageLinks" => $gallry_images);
            } else {
                $res = array("exception" => "No Image Found");
            }
        }else{
            $res = array("exception" => "Invelid Token Info");
        }
        return $res;
    }

    public function actionClientLogin()
    {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];

        $client_info = ClientInfo::find()->where(['UserName' => $user])->andWhere(['Password' => $pass])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
        if(!empty($client_info)) {
            $company_info = CommonFunctions::selectCompanyBranchInfo($client_info->BranchID);
            $company_projects = Projects::find()->where(['CompanyID' => $company_info->CompanyID])->andWhere(AppConstants::get_active_record_only)->all();
            $client_id = $client_info->ID;
            $investment_info = ClientInvestment::find()->where(['ClientID' => $client_id])->andWhere(AppConstants::get_active_record_only)->one();
            $project_id = $investment_info->ProjectID;
            $project_info = Projects::find()->where(['ID' => $project_id])->andWhere(['Active' => 'Y'])->andWhere(AppConstants::get_active_record_only)->one();
            $gallery_info = ProjectGallery::find()->where(['ImageFor'=>'android'])->andWhere(['ProjectID'=>$project_info->ID])->andwhere(AppConstants::get_active_record_only)->orderBy(['rand()' => SORT_DESC])->limit(1)->one();

            for ($i = 1; $i <= 3; $i++) {
                $project_name = $project_info->ProjectName;
                $validity = date('d M, Y',strtotime($investment_info->ContractExpiryDate));
                $month_instive = number_format(100000,0);
                $t_inv = number_format(10000000,0);
                $t_date_inst = number_format(400000,0);
                $rcved = number_format(300000,0);
                $bln = number_format(100000,0);

                if($i == 1){
                    $concat = '';
                    $project_name = 'Arcade-I';
                }else{
                    $concat = $i;
                }
                if($i == 1){ $projectid = 4;}
                if($i == 2){ $projectid = 2;}
                if($i == 3){ $projectid = 7;}
                $gallery_info = ProjectGallery::find()->where(['ImageFor'=>'android'])->andWhere(['ProjectID'=>$projectid])->andwhere(AppConstants::get_active_record_only)->orderBy(['rand()' => SORT_DESC])->limit(1)->one();

                $project_img_link = AppConstants::ProjectImgUrl.'/'.$gallery_info->ImageName;
                if($i == 2){$project_name = 'Business Centre';$validity = '12 Aug, 2022'; $t_inv = number_format(250000,0); $month_instive = number_format(300000,0); $t_date_inst = number_format(50000,0); $rcved = number_format(700512,0);$bln = number_format(102500,0);}
                if($i == 3){$project_name = 'OCTA';$validity = '31 Dec, 2026'; $t_inv = number_format(1500000,0); $month_instive = number_format(400000,0); $t_date_inst = number_format(2503698,0); $rcved = number_format(102590,0); $bln = number_format(25000,0);}
                $projects[] = array("Project" => $project_name, "ContractValidity" => $validity, "TotalInvestment" => $t_inv, "MonthlyInsentive" => $month_instive, "TillDateAmountIncentive" => $t_date_inst, "Recieved" => $rcved, "Balance" => $bln,"ImageLink"=>$project_img_link);
            }

            ///company projects/////
            if(!empty($project_info)){
                foreach($company_projects as $p){
                    $Investment = 0;
                    $MonthlyInsentive = 0;
                    $TillDateAmountRcv = 0;
                    if($p->ID == 2){
                        $Investment = 100000;
                        $MonthlyInsentive = 10000000;
                        $TillDateAmountRcv = 300000;
                    }
                    if($p->ID == 5){
                        $Investment = 250000;
                        $MonthlyInsentive = 300000;
                        $TillDateAmountRcv = 700512;
                    }

                    if($p->ID == 7){
                        $Investment = 1500000;
                        $MonthlyInsentive = 400000;
                        $TillDateAmountRcv = 102590;
                    }

                    $company_active_projects[] = array("ProjectName"=>$p->ProjectName,"Investment"=>number_format($Investment,0),"MonthlyInsentive"=>number_format($MonthlyInsentive),"TillDateAmountRcv"=>number_format($TillDateAmountRcv));
                }
            }else{
                $company_active_projects[] = array();
            }

            $client_profile_img = "http://aaacrm.net/aaacms/web/emp_images/blankM.jpg";
            $company_profile_img = "http://aaacrm.net/aaacms/web/logo_image/20200827170716aaa_logo.png";

            $clientProfile = array("name" => ucfirst($client_info->FirstName), "LastName" => ucfirst($client_info->LastName), "Cnic" => $client_info->Cnic, "MemberID" => "AAA-587", "ProfileImg" => $client_profile_img);
            $companyProfile = array("CompanyName" => "AAA Associates", "WhatsAppNo" => $company_info->WhattsappNumber, "Support" => $company_info-> 	CustomerSupport, "logo" => $company_profile_img);

            //$res = array("client" => $clientProfile, "investments" => $projects, "CompanyProfile" => $companyProfile);
            $res = array("client" => array($clientProfile),"CompanyProfile" => array($companyProfile),"investments" => $projects,"CompanyProjects"=>$company_active_projects);
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