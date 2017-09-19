<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:29
 */

namespace core\controllers;


/**
 * Class MainController
 * @package controllers
 */
class MainController extends BaseController
{
    /**
     * Тестовый метод
     */
    public function actionIndex(): void
    {
        $this->render("index", [
                "content" => "Hello, " . AppName . "! 😎"
            ]
        );
    }
}