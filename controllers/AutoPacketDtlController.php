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
class AutoPacketDtlController extends Controller
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

    public function actionPacketDtlMaking()
    {
        $Packet_record = JobPackets::find()->where('PostsStatus = 0')->limit(5)->all();

        if (!empty($Packet_record)) {

            foreach ($Packet_record as $value) {

                $packetID = $value->ID;


                $contact_record = ContactNumberList::find()->where('Assigned = "N"')->all();

                if (!empty($contact_record)) {

                    foreach ($contact_record as $value) {

                        $contactID = $value->ID;
                        $contactNo = $value->ContactNumber;
                        $contactNotes = $value->ContactNotes;

                    }

                        $date = date('Y-m-d H:i:s');

                        for ($i = 0; $i <= 10; $i++) {
                            $model = new JobPacketDtl();
                            $model->PacketID = $packetID;
                            $model->ContactID = $contactID;
                            $model->ContactNumber = $contactNo;
                            $model->ContactNotes = $contactNotes;
                            $model->EnteredBy = 2;
                            $model->EnteredOn = $date;
                            $model->BranchID = 2;
                            if ($model->save()) {
                                $sqL = 'update contact_number_list set Assigned = "Y" where ID = ."$contactID"';
                                Yii::$app->contact_db->createCommand($sqL)->execute();
                                //return $this->redirect(['index']);
                            } else {
                                print_r($model->getErrors());
                                exit();
                            }
                        }


                    }

                }

            }

            $sql = 'update job_packets set PostsStatus = 1 limit 10 ';
            Yii::$app->contact_db->createCommand($sql)->execute();


            exit();

        }

    }
