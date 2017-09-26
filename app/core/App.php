<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:12
 */

namespace App\Core;

use App\Controllers\BaseController;

/**
 * Class App
 * @package Core
 */
class App
{
    use Singleton;

    /**
     * Метод инициализации приложения
     */
    public function run()
    {
        // Запускаем роутер
        $router = new Route();
        $router->run();

        $controller = $router->getController();
        $action     = $router->getAction();

        // вызываем метод, если он существует
        if (class_exists($controller) && method_exists($controller, $action)) {
            (new $controller())->$action();
        } else {
            (new BaseController())->render('errors/404', []);
        }
    }
}

