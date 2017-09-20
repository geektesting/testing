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
    /**
     * @param array $data
     */
    public function actionIndex(array $data = []): void
    {
        $this->render("index", [
                "content" => "Hello, " . AppName . "! 😎",
                "test" => array_shift($data)
            ]
        );
    }

    /**
     * @param array $numbers
     */
    public function actionNumber(array $numbers): void
    {
        $this->render("numbers", [
                "numbers" => $numbers
            ]
        );
    }
}