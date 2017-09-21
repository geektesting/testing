<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:12
 */

namespace App\Core;

use App\controllers\BaseController;

/**
 * Class App
 * @package core
 */
class App
{
    use Singleton;

    /**
     * Метод инициализации приложения
     */
    public function run(): void
    {
        // Запускаем роутер
        $router = new Route();
        $router->run();

        $controller = $router->getController();
        $action = $router->getAction();

        // вызываем метод, если он существует
        if (class_exists($controller) && method_exists($controller, $action))
            call_user_func_array([(new $controller()), $action], $router->getArgs());
        else
            (new BaseController())->render('errors/404', []);

    }

}