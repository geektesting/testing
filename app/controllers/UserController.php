<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 20.09.2017
 * Time: 21:56
 */

namespace App\Controllers;

/**
 * Class UserController
 * @package Controllers
 */
class UserController extends BaseController
{
    /**
     * ActionIndex
     */
    public function actionIndex()
    {
        echo 'Hello from ' . __METHOD__;
    }
    
    /**
     * ActionAbout
     */
    public function actionAbout()
    {
        echo 'Hello from ' . __METHOD__;
    }
}