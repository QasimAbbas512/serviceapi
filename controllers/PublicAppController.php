<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;
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

        $reponce = '[{"member_link":"1","guest_link":"2"}]';
        $res = array("links"=>$reponce);

        return $res;
    }

}
