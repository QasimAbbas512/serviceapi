<?php
/**
 * Yii2 test controller
 *
 * @category  Web-yii2-example
 * @package   yii2-curl-example
 * @author    Nils Gajsek <info@linslin.org>
 * @copyright 2013-2015 Nils Gajsek<info@linslin.org>
 * @license   http://opensource.org/licenses/MIT MIT Public
 * @version   1.0.5
 * @link      http://www.linslin.org
 *
 */

namespace app\controllers;

use yii\web\Controller;
use linslin\yii2\curl;

class TestController extends Controller
{

    /**
     * Yii action controller
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * cURL GET example
     */
    public function actionGetExample()
    {
        //Init curl
        $curl = new curl\Curl();

        //get http://example.com/
        $response = $curl->get('http://example.com/');
    }


    /**
     * cURL POST example with post body params.
     */
    public function actionPostExample()
    {
        //Init curl
        $curl = new curl\Curl();

        //post http://example.com/
        $response = $curl->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query(array(
                    'myPostField' => 'value'
                )
            ))
            ->post('http://example.com/');
    }


    /**
     * cURL multiple POST example one after one
     */
    public function actionMultipleRequest()
    {
        //Init curl
        $curl = new curl\Curl();


        //post http://example.com/
        $response = $curl->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query(array(
                    'myPostField' => 'value'
                )
            ))
            ->post('http://example.com/');


        //post http://example.com/, reset request before
        $response = $curl->reset()
            ->setOption(
                CURLOPT_POSTFIELDS,
                http_build_query(array(
                        'myPostField' => 'value'
                    )
                ))
            ->post('http://example.com/');
    }


    /**
     * cURL advanced GET example with HTTP status codes
     */
    public function actionGetAdvancedExample()
    {
        //Init curl
        $curl = new curl\Curl();

        //get http://example.com/
        $response = $curl->post('http://example.com/');

        // List of status codes here http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        switch ($curl->responseCode) {

            case 'timeout':
                //timeout error logic here
                break;

            case 200:
                //success logic here
                break;

            case 404:
                //404 Error logic here
                break;
        }
    }


    /**
     * cURL timeout chaining/handling
     */
    public function actionHandleTimeoutExample()
    {
        //Init curl
        $curl = new curl\Curl();

        //get http://www.google.com:81/ -> timeout
        $response = $curl->post('http://www.google.com:81/');

        // List of status codes here http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        switch ($curl->responseCode) {

            case 'timeout':
                //timeout error logic here
                break;

            case 200:
                //success logic here
                break;

            case 404:
                //404 Error logic here
                break;
        }
    }
}