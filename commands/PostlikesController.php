<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\CronTbl;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PostlikesController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
//        echo $message . "\n";
//
//        return ExitCode::OK;
        $chk = CronTbl::find()->orderBy('ID')->one();
        if(!empty($chk)){
            $get_val = $chk->SetNum;
            $new_num = $get_val + 3;
            $mdl = new CronTbl();
            $mdl->SetNum = $new_num;
            $mdl->LastTime = date('Y-m-d H:i:s');
            if($mdl->save()){
            echo 'Record Added';
                $x = $_SERVER['DOCUMENT_ROOT'];
                echo phpinfo();
                print_r($x);
            exit();
            }else{
                print_r($mdl->getErrors());exit();
            }
        }

    }
}
