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
        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

        $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 limit ' . $GetNodeRequestLimit;
        Yii::$app->machine_db->createCommand($sql)->execute();


        $data = NodeRequestedDate::find()->where(['RequestDestination' => "call_response_multiple"])
            ->andWhere(['Status' => 0])
            ->andWhere(['Picked' => 1])
            ->andWhere(['Completed' => 0])
            ->andWhere(['Tried' => 0])
            ->orderBy(['ID' => SORT_DESC])->all();

        if (!empty($data)) {

            $transaction = Yii::$app->machine_db->beginTransaction();
            try {

                foreach ($data as $val) {

                    $id = $val->ID;

                    $PickedTime = date('Y-m-d H:i:s');

                    $data_packet = $val->DataPacket;
                    $data_pkt = json_decode($data_packet);
                    $pkt_uuid = $data_pkt->UUID;
                    $emp_id = $data_pkt->EmployeeID;
                    $branch_id = $data_pkt->BranchID;
                    $date = $data_pkt->DateTime;
                    $data_pkt = json_decode($data_pkt->Data);
//                echo '<pre>';
//                print_r($data_pkt);
//                exit();

                    if (!empty($data_pkt)) {

                        $transaction1 = Yii::$app->machine_db->beginTransaction();
                        try {

                        $z = 0;
                        foreach ($data_pkt as $v) {

                            $call_pkt = json_encode($v);
                            $call_uuid = $v->UUID;
                            $destination = 'call_response';
                            echo $v->ContactID . '<br>';

                            $sendToNode = CommonFunctions::SaveNodes($destination, $call_pkt, $call_uuid);

                                $CompletedTime = date('Y-m-d H:i:s');
                                $Tried = 1;

                            if ($sendToNode == 2) {
                                $z++;
                                continue;
                            }


                        } $transaction1->commit();
                        } catch
                        (Exception $e) {
                            $transaction->rollback();
                        }
                    }

                    echo $z . "Done";
                    exit();
                }

//            echo "<pre>";
//            print_r($data);
//            exit();

                $transaction->commit();
            } catch
            (Exception $e) {
                $transaction->rollback();
            }

        }

        $update_status = 'update node_requested_date set Status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", Tried = "' . $Tried . '"  where ID = "' . $id . '"';
        Yii::$app->machine_db->createCommand($update_status)->execute();
    }
}