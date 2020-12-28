<?php

namespace app\controllers;

use Yii;
use app\models\JobPacketDtl;
use app\models\JobPackets;
use app\models\ContactNumberList;
use app\models\JobPacketDtlSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobPacketDtlController implements the CRUD actions for JobPacketDtl model.
 */
class AutoPacketController extends Controller
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
     * Lists all JobPacketDtl models.
     * @return mixed
     */
    
    public function actionPacketMaking()
    {
        $toDate = date('Y-m-d');
        $FromDate = date('Y-m-d');
        $date = date('Y-m-d H:i:s');
        $model = new JobPackets();    
        for ($i=0; $i <=10; $i++)
        {
        $model = new JobPackets();
        $PacketName = $toDate."--".$FromDate;
        $model->PacketName = $PacketName;
        $model->Description = "Testing for app";
        $model->ToDate = $toDate;
        $model->FromDate = $FromDate;
        $model->EnteredBy = 2;
        $model->EnteredOn = $date;
        $model->BranchID = 2;
        $model->PostsStatus = 0;
         echo $PacketName.'<br>';
        
        if ($model->save()) {
                //return $this->redirect(['index']);
            }else{
                print_r($model->getErrors());exit();
            }      
        }

        exit();
    }
    
}
