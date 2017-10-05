<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:29
 */

namespace App\Controllers;

use \App\Config;
use \App\Models\Cats;

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
            "cats" => Cats::catList("front"),
            "numbers" => Cats::$numbers
        ]);
    }

    /**
     * ActionAbout
     */
    public function actionAbout()
    {
        echo 'Hello from ' . __METHOD__;
    }
}