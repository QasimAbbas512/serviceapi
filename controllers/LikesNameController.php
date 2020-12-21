<?php

namespace app\controllers;

use app\models\ContactNumberList;
use app\models\Filtered;
use app\models\MediaPostLikedby;
use app\models\NodeRequestedDate;
use app\models\ClientInfo;
use app\models\JobPackets;
use app\models\JobPacketDtl;
use Yii;
use CommonFunctions;
use AppConstants;
use app\models\MediaPostRanking;
use app\models\MediaLinks;
use app\models\PagesCredentials;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MediaPostRankingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return \yii\web\Response
     */

    public function actionPostLikesNames()
    {

        $page_row_id = 4;
        $get_links = MediaLinks::find()->where('ID =' . $page_row_id)->all();
        if (!empty($get_links)) {
            $likes = 0;
            foreach ($get_links as $vals) {
                $get_tokens = PagesCredentials::find()->where(['PageID' => $vals->ID])->one();

                if (!empty($get_tokens)) {
                    $app_id = $get_tokens->AppID;
                    $AppSecret = $get_tokens->AppSecret;
                    $PageToken = $get_tokens->PageToken;
                    $pageID = $get_tokens->PageUserID;
                    $data_objects = CommonFunctions::fbpostlikesnames($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

                    echo "<pre>";
                    print_r($body_data);
                    exit();

                    $i = 0;
                    foreach ($body_data as $k) {
                        $i++;
                        $post_id = '';
                        $created_time = '';
                        $likes = 0;
                        $shares = 0;
                        $total_shares = 0;
                        $total_likes = 0;

                        $created_time_val = $k->created_time;
                        if (!empty($k->message)) {
                            $message = $k->message;
                        } else {
                            $message = '--';
                        }
                        $id = $k->id;
                        $reactions_array = $k->reactions;
                        $shar_array = $k->shares;

//                        echo '<pre>';
//                        print_r($shar_array);
//                        exit();

                        foreach ($reactions_array as $x => $reac_vals) {
                            if (!empty($reac_vals->total_count)) {
                                $total_likes = $reac_vals->total_count;
                            }
                        }

//                        foreach ($shar_array as $p => $share_vals) {
//                            $total_shares = $share_vals;
//                        }
                        if (!empty($shar_array->count)) {
                            $total_shares = $shar_array->count;
                        }

                        $post_value_id = explode('_', $id);
                        $post_id = $post_value_id[1];
                        $created_time = date('Y-m-d H:i:s', strtotime($created_time_val));
                        $date = date('Y-m-d');
                        $likes = $total_likes;
                        $shares = $total_shares;

                        $mdl = new MediaPostRanking();
                        $mdl->CreatedOn = $created_time;
                        $mdl->PostID = $post_id;
                        $mdl->TotalShare = $shares;
                        $mdl->PostMessage = $message;
                        $mdl->CountDate = $date;
                        $mdl->MediaID = 1;
                        $mdl->MediaPageID = $page_row_id;
                        $mdl->TotalLikes = $likes;
                        $mdl->Active = 'Y';
                        $mdl->EnteredOn = date('Y-m-d H:i:s');
                        $mdl->EnteredBy = 2;
                        $mdl->BranchID = 2;
                        $mdl->IsDeleted = 'N';

                        $validation = MediaPostRanking::find()->where(['PostID' => $post_id])->andWhere(['MediaPageID' => $page_row_id])->andWhere(['CountDate' => $date])->one();
                        if (!empty($validation)) {
                            continue;
                        }
                        if ($mdl->save()) {
                        } else {
                            print_r($mdl->getErrors());
                            exit();
                        }

                    }
                }
            }

        }

        echo 'Done';
        exit();

    }

}