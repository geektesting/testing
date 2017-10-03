<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:23
 */

namespace App\Controllers;

use \App\Config;
use App\Models\User;

/**
 * Class BaseController
 * @package Controllers
 */
class BaseController
{
    /**
     * isAuth
     * @return bool 
     */
    protected function isAuth() : bool
    {
        $user = (new User())->getCurrent();
        return !!$user;
    }

    /**
     * getUserRole
     * @return int|null
     */
    protected function getUserRole()
    {
        $user = (new User())->getCurrent();
        return ($user) ? $user->getRole() : null;
    }

    /**
     * Метод рендеринга
     * @param string $template - имя шаблона
     * @param array $data - массив данных
     */
    public function render(string $template, array $data = [])
    {
        $twig = new \Twig_Environment(
            new \Twig_Loader_Filesystem(Config::$app["VIEWS"]), []
        );

        $isAuth = ["isAuth" => $this->isAuth()];
        echo $twig->render($template . '.tmpl', array_merge($data, $isAuth));
    }
}