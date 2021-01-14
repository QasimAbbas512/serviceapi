<?php

namespace app\controllers;

use CommonFunctions;
use AppConstants;
use app\models\NodeRequestedDate;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class PacketSeprationController extends Controller
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
     * to seperate the response data from call_response_multiple
     */
    public function actionResponse()
    {

        $data = NodeRequestedDate::find()->where(['RequestDestination' => "call_response_multiple"])
            ->andWhere(['Status' => 0])
            ->andWhere(['Picked' => 0])
            ->andWhere(['Completed' => 0])
            ->andWhere(['Tried' => 0])
            ->orderBy(['ID' => SORT_DESC])->all();

        foreach ($data as $val) {
            $id = $val->ID;
            $data_packet = $val->DataPacket;
            $data_pkt = json_decode($data_packet);
            $pkt_uuid = $data_pkt->UUID;
            $emp_id = $data_pkt->EmployeeID;
            $branch_id = $data_pkt->BranchID;
            $date = $data_pkt->DateTime;
            $call_data = json_decode($data_pkt->Data);
//                echo '<pre>';
//                print_r($call_data);
//                exit();
            foreach ($call_data as $v) {
                $call_pkt = json_encode($v);
                $call_uuid = $v->UUID;
                $destination = 'call_response';
                //echo $v->ContactID.'<br>';
                //$sendToNode = CommonFunctions::SaveNodes($destination,$call_pkt,$call_uuid);
                //if($sendToNode == 2){continue;}

//
                }

//            $sql = 'update node_requested_date set Picked = 1 and status = 1 and Completed = 1 and Tried = 1 where ID ='.$id;
//                Yii::$app->machine_db->createCommand($sql)->execute();


            }
        echo "Done";
        exit();
        }

//            echo "<pre>";
//            print_r($data);
//            exit();

}