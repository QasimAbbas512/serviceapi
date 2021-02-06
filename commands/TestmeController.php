<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\CronTbl;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TestmeController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
//    public function actionIndex($message = 'hello world')
//    {
//        echo $message . "\n";
//
//        return ExitCode::OK;
//    }

    public function actionIndex(){
        $chk = CronTbl::find()->orderBy('ID')->one();
        if(!empty($chk)){
            $get_val = $chk->SetNum;
            $new_num = $get_val + 3;
            $mdl = new CronTbl();
            $mdl->SetNum = $new_num;
            $mdl->LastTime = date('Y-m-d H:i:s');
            if($mdl->save()){
            echo 'Record Added';exit();
            }else{
                print_r($mdl->getErrors());exit();
            }
        }
    }
}
