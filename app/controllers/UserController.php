<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 20.09.2017
 * Time: 21:56
 */

namespace App\controllers;


class UserController extends BaseController
{
    public function actionIndex()
    {
        echo 'Hello from ' . __METHOD__;
    }
    public function actionAbout()
    {
        echo 'Hello from ' . __METHOD__;
    }
}