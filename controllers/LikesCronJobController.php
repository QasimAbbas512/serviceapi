<?php

namespace app\controllers;

use Yii;
use app\models\MediaPageRanking;
use app\models\JobPackets;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * JobPacketDtlController implements the CRUD actions for JobPacketDtl model.
 */
class JobPacketDtlController extends Controller
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
    
    public function actionLikesFetching()
    {
        $date = date('Y-m-d H:i:s');
        $RankingDate = date('Y-m-d H:i:s');
        $model = new MediaPageRanking();

        $posts_list = MediaLinkPosts::find()->all();

            foreach($posts_list as $val){
                $chk_val = PagesCredentials::find()->where(['PageID' => $val->LinkID])->one();
                $likes = 0;
                $postID=$val->PostID;
                if(!empty($chk_val)){
                    $app_id = $chk_val->AppID;
                    $AppSecret = $chk_val->AppSecret;
                    $PageToken = $chk_val->PageToken;
                    $pageID = $chk_val->PageUserID;
                    $likes = CommonFunctions::fbpostlikes($app_id,$AppSecret,$PageToken,$postID,$pageID);
                }

                echo "<pre>";
                print_r($likes);
                exit();

//        $model = new JobPackets();
//        $PacketName = $toDate."--".$FromDate;
//        $model->PacketName = $PacketName;
//        $model->Description = "blah blah blah";
//        $model->ToDate = $toDate;
//        $model->FromDate = $FromDate;
//        $model->EnteredBy = 1;
//        $model->EnteredOn = $date;
//        $model->BranchID = 1;
//        $model->PostsStatus = 0;
//         echo $PacketName.'<br>';
        
        if ($model->save()) {
                //return $this->redirect(['index']);
            }else{
                print_r($model->getErrors());exit();
            }      


        exit();
    }
    
}
