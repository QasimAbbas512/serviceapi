<?php

namespace app\controllers;

use CommonFunctions;
use AppConstants;
use app\models\NodeRequestedDate;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class PendingJobController extends Controller
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
    public function actionPending()
    {
        $data = NodeRequestedDate::find()->where(['RequestDestination' => "bulk_pending_by_user"])
            ->andWhere(['Status' => 0])
            ->andWhere(['Picked' => 0])
            ->andWhere(['Completed' => 0])
            ->andWhere(['Tried' => 0])
            ->orderBy(['ID' => SORT_DESC])->all();

        if (!empty($data)) {

                foreach ($data as $val) {

                    $id = $val->ID;

                    $data_packet = $val->DataPacket;
                    $data_pkt = json_decode($data_packet);

                echo '<pre>';
                print_r($data_pkt);
                exit();

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

                }

//            echo "<pre>";
//            print_r($data);
//            exit();

                $transaction->commit();

                $update_status = 'update node_requested_date set Status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", Tried = "' . $Tried . '"  where ID = "' . $id . '"';
                Yii::$app->machine_db->createCommand($update_status)->execute();



            echo $z . "Done";
            exit();

        }

    }
}