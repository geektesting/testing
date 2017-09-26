<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:29
 */

namespace App\Controllers;

use \App\Config;

/**
 * Class MainController
 * @package controllers
 */
class MainController extends BaseController
{

    /**
     * ActionIndex
     */
    public function actionIndex()
    {
        $this->render("index", [
                "content" => "Hello, " . Config::$app["NAME"] . "! 😎"
            ]
        );
    }

    /**
     * ActionAbout
     */
    public function actionAbout()
    {
        echo 'Hello from ' . __METHOD__;
    }
}