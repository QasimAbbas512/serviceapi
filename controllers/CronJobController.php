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

    public function actionCall()
    {

        $model_req = new NodeRequestedDate();
        
                 echo 'asdasdas';exit();   
        $call_action_data = '[{"MacAddress":"WSD3:9l:440:45","UserID":"21","CompanyID":"34","ContactID":"345632","ResponseValues":"3","ProfileInfo":"Address location area etc","VoiceCall":"CallFileName.aac","AudioNote":"VoiceNote.aac","OtherNotes":"text notes"}]';

        $model_req->DataPacket = $call_action_data;    
        $model_req->RequestDestination = 'mobile_call_dump';
        $model_req->ReceivedOn = date('Y-m-d H:i:s');
        $model_req->DataPacket = $call_action_data;
       

            if($model_req->save()) {
                $responce = array("Code"=>200,"message"=>"Save Sucessfully");
            }else{
                $responce = array("Code"=>203,"message"=>"Not posted Properly");
            }
        echo $responce;exit();

        
    }
    
    }