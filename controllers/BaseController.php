<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:23
 */

namespace controllers;


/**
 * Class BaseController
 * @package controllers
 */
class BaseController
{
    /**
     * Метод рендеринга
     * @param string $template - имя шаблона
     * @param array $data - массив данных
     */
    public function render(string $template, array $data): void
    {
        $twig = new \Twig_Environment(
            new \Twig_Loader_Filesystem('../views/'), []
        );

        echo $twig->render($template . '.tmpl', [
                'data' => $data
            ]
        );
    }
}