<?php

//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(E_ALL);
//error_reporting(0);

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../cms/vendor/autoload.php';
require __DIR__ . '/../../cms/vendor/yiisoft/yii2/Yii.php';

Yii::$classMap['CommonFunctions'] = __DIR__ . '/../../aaaCentralFiles/CommonFunctions.php';
Yii::$classMap['AppConstants'] = __DIR__ . '/../../aaaCentralFiles/CommonFunctions.php';



$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
//$application = new yii\web\Application($config);
//$application->on(yii\web\Application::EVENT_BEFORE_REQUEST, function(yii\base\Event $event){
//    $event->sender->response->on(yii\web\Response::EVENT_BEFORE_SEND, function($e){
//        ob_start("ob_gzhandler");
//    });
//    $event->sender->response->on(yii\web\Response::EVENT_AFTER_SEND, function($e){
//        ob_end_flush();
//    });
//});
//$application->run();
