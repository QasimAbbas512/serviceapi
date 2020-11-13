<?php

namespace app\controllers;

use app\models\MediaPageRanking;
use app\models\NodeRequestedDate;
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

    public function actionRanking()
    {

        $page_row_id = 33;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----1-----";

        $page_row_id = 32;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----2-----";

        $page_row_id = 31;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----3-----";

        $page_row_id = 27;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----4-----";

        $page_row_id = 26;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----5-----";

        $page_row_id = 18;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----6-----";

        $page_row_id = 28;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----7-----";

        $page_row_id = 16;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----8-----";

        $page_row_id = 12;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----9-----";

        $page_row_id = 10;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----10-----";

        $page_row_id = 7;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----11-----";

        $page_row_id = 6;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----12-----";

        $page_row_id = 5;
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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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
        echo "-----13-----";

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
                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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

//                        $last_count = MediaPostRanking::find()->where(['PostID' => $post_id])->andWhere(['MediaPageID'=>$page_row_id])->groupBy('ID desc')->one();
//                        if(!empty($last_count)){
//                            $last_like_count = $last_count->TotalLikes;
//                            $last_share_count = $last_count->TotalShare;
//
//                            $new_likes = $total_likes - $last_like_count;
//                            $mdl->newLikes = $new_likes;
//                        }
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
        echo "-----14-----";

        echo 'Done';
        exit();

    }

    public function actionCredentials()
    {

        $sample = '[{"app_id":"xxxxxx",
        "app_secret":"xx",
        "page_token":"xx",
        "Page_id":"xx",
        }]';

        $get_data_qry = PagesCredentials::find()->all();

        if (!empty($get_data_qry)) {
            foreach ($get_data_qry as $get_data) {
                $app_id = $get_data->AppID;
                $AppSecret = $get_data->AppSecret;
                $PageToken = $get_data->PageToken;
                $pageID = $get_data->PageUserID;
                $mediaPageID = $get_data->PageID;
                unset($data);

                $data[] = array('PageID' => $mediaPageID, 'AppID' => $app_id, 'AppSecret' => $AppSecret, 'PageToken' => $PageToken, 'PageUserID' => $pageID);
                $data_vals = json_encode($data);

                $RequestDestination = "Media_Ranking";

                $data_objects = CommonFunctions::SaveNodes($RequestDestination, $data_vals);

            }//end foreach
        }//end if not empty
    }

    public function actionPost()
    {

//        [{"AppID":"281717699831859 ",
//        "AppSecret":"e3d0cb76a6589dc9d7382e12397bc05c",
//        "PageToken":"EAAEAOINs6DMBAHxh61uSS8RsXLorGZBLUqbr3jetxXCIEXq5ZAVmMVPhee4ALr1xlFL6JNZBLZAxyJKntQQZB3Cp0xTwQetCoyYDLRxEw4juRcYkjve7KPFS3Oj4l28K1sbrxRQzZAk040Yxzzn9wm2uMoKog0gvlyS5wPfJOoU2VJD206nAJ3",
//        "PageUserID":"109747260742499"}]


        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

        $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 limit ' . $GetNodeRequestLimit;
        Yii::$app->machine_db->createCommand($sql)->execute();

        $post_record = NodeRequestedDate::find()->where('Status = 0 and Picked = 1 and Completed =0')->all();
        if (!empty($post_record)) {


            foreach ($post_record as $value) {

                $row_id = $value->ID;
                $PickedTime = date('Y-m-d H:i:s');

                $requested_data = $value->DataPacket;
                $data = json_decode($requested_data);

                foreach ($data as $key => $val) {

                    $app_id = $val->AppID;
                    $AppSecret = $val->AppSecret;
                    $PageToken = $val->PageToken;
                    $pageID = $val->PageUserID;
                    $page_row_id = $val->PageID;


                    $data_objects = CommonFunctions::fbpostlikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_data = $body_array->data;

//                    echo "<pre>";
//                    print_r($body_data);
//                    exit();

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

                        if (!empty($shar_array->count)) {
                            $total_shares = $shar_array->count;
                        }

                        $post_value_id = explode('_', $id);
                        $post_id = $post_value_id[1];
                        $created_time = date('Y-m-d H:i:s', strtotime($created_time_val));
                        $date = date('Y-m-d');
                        $likes = $total_likes;
                        $shares = $total_shares;

//                        echo '<pre>';
//                        print_r($shares);
//                        exit();

                        $model = new MediaPostRanking();
                        $model->CreatedOn = $created_time;
                        $model->PostID = $post_id;
                        $model->TotalShare = $shares;
                        $model->CountDate = $date;
                        $model->MediaID = 1;
                        $model->MediaPageID = $page_row_id;
                        $model->TotalLikes = $likes;
                        $model->Active = 'Y';
                        $model->EnteredOn = date('Y-m-d H:i:s');
                        $model->EnteredBy = 2;
                        $model->BranchID = 2;
                        $model->IsDeleted = 'N';

//                        echo 'here is the issue';
//                        exit();

                        $validation = MediaPostRanking::find()->where(['PostID' => $post_id])->andWhere(['MediaPageID' => $page_row_id])->andWhere(['CountDate' => $date])->one();
                        if (!empty($validation)) {

                            continue;
                        }

                        if ($model->save()) {
                            $CompletedTime = date('Y-m-d H:i:s');
                            $Tried = 1;
                            $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';

                            Yii::$app->machine_db->createCommand($update_status)->execute();
                        } //else {print_r($model->getErrors());exit();}

                        else {
                            echo '<pre>';
                            print_r($model->getErrors());
                            exit();

                        }

                    }
                    echo 'Done';
                }

            }
        }
    }

    public function actionPageLikes()
    {

        $page_row_id = 33;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }


        $page_row_id = 32;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }

        }

        $page_row_id = 31;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 28;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 27;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 26;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 18;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 16;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 12;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 10;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 7;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 6;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

        $page_row_id = 5;
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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }

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
                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date= date('Y-m-d');

//                    echo "<pre>";
//                    print_r($total_likes);
//                    exit();

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                    } else {
                        print_r($model->getErrors());
                        exit();
                    }

                }
                echo "done";
            }
        }
    }

    public function actionJob()
    {

        $sample = '[{"app_id":"xxxxxx",
        "app_secret":"xx",
        "page_token":"xx",
        "Page_id":"xx",
        }]';

        $get_data_qry = PagesCredentials::find()->all();

        if (!empty($get_data_qry)) {
            foreach ($get_data_qry as $get_data) {
                $app_id = $get_data->AppID;
                $AppSecret = $get_data->AppSecret;
                $PageToken = $get_data->PageToken;
                $pageID = $get_data->PageUserID;
                $mediaPageID = $get_data->PageID;
                unset($data);

                $data[] = array('PageID' => $mediaPageID, 'AppID' => $app_id, 'AppSecret' => $AppSecret, 'PageToken' => $PageToken, 'PageUserID' => $pageID);
                $data_vals = json_encode($data);

                $RequestDestination = "Page_Ranking";

                $data_objects = CommonFunctions::SaveNodes($RequestDestination, $data_vals);

            }//end foreach
        }//end if not empty
    }

    public function actionPage()
    {

//        [{"AppID":"281717699831859 ",
//        "AppSecret":"e3d0cb76a6589dc9d7382e12397bc05c",
//        "PageToken":"EAAEAOINs6DMBAHxh61uSS8RsXLorGZBLUqbr3jetxXCIEXq5ZAVmMVPhee4ALr1xlFL6JNZBLZAxyJKntQQZB3Cp0xTwQetCoyYDLRxEw4juRcYkjve7KPFS3Oj4l28K1sbrxRQzZAk040Yxzzn9wm2uMoKog0gvlyS5wPfJOoU2VJD206nAJ3",
//        "PageUserID":"109747260742499"}]


        $GetNodeRequestLimit = AppConstants::getNodeRequestLimit;

        $sql = 'update node_requested_date set Picked = 1 where status = 0 and Completed = 0 and Picked = 0 limit ' . $GetNodeRequestLimit;
        Yii::$app->machine_db->createCommand($sql)->execute();

        $post_record = NodeRequestedDate::find()->where('Status = 0 and Picked = 1 and Completed =0')->all();
        if (!empty($post_record)) {


            foreach ($post_record as $value) {

                $row_id = $value->ID;
                $PickedTime = date('Y-m-d H:i:s');

                $requested_data = $value->DataPacket;
                $data = json_decode($requested_data);

                foreach ($data as $key => $val) {

                    $app_id = $val->AppID;
                    $AppSecret = $val->AppSecret;
                    $PageToken = $val->PageToken;
                    $pageID = $val->PageUserID;
                    $page_row_id = $val->PageID;


                    $data_objects = CommonFunctions::fbpagelikes($app_id, $AppSecret, $PageToken, '', $pageID);
                    $body_array = json_decode($data_objects);
                    $body_array = json_decode($data_objects);
//                    $body_data = $body_array->data;

                    if (!empty($body_array->fan_count)) {
                        $total_likes = $body_array->fan_count;
                    }

                    $likes = $total_likes;
                    $date = date('Y-m-d');

                    $model = new MediaPageRanking();
                    $model->TotalShare = 0;
                    $model->TotalComments = 0;
                    $model->MediaID = 1;
                    $model->MediaPageID = $page_row_id;
                    $model->TotalLikes = $likes;
                    $model->RankingDate = date('Y-m-d');
                    $model->Active = 'Y';
                    $model->EnteredOn = date('Y-m-d H:i:s');
                    $model->EnteredBy = 2;
                    $model->BranchID = 2;
                    $model->IsDeleted = 'N';

//                        echo 'here is the issue';
//                        exit();

                    $validation = MediaPageRanking::find()->where(['MediaPageID' => $page_row_id])->andWhere(['RankingDate' => $date])->one();
                    if (!empty($validation)) {
                        continue;
                    }

                    if ($model->save()) {
                        $CompletedTime = date('Y-m-d H:i:s');
                        $Tried = 1;
                        $update_status = 'update node_requested_date set Picked = 1, status = 1, Completed = 1, PickedTime = "' . $PickedTime . '", CompletedTime = "' . $CompletedTime . '", Tried = "' . $Tried . '"  where ID = "' . $row_id . '"';

                        Yii::$app->machine_db->createCommand($update_status)->execute();
                    } //else {print_r($model->getErrors());exit();}

                    else {
                        echo '<pre>';
                        print_r($model->getErrors());
                        exit();

                    }

                }
                echo 'Done';
            }
        }
    }
}
