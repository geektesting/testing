<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:29
 */

namespace App\controllers;

/**
 * Class MainController
 * @package controllers
 */
class MainController extends BaseController
{

    public function actionIndex(): void
    {
        $this->render("index", [
                "content" => "Hello, " . AppName . "! 😎"
            ]
        );
    }

    public function actionAbout(): void
    {
        echo 'Hello from ' . __METHOD__;
    }
}