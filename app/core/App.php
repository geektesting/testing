<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:12
 */

namespace App\Core;

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
//        // Запускаем роутер
//        $router = new Route();
//        $router->run();
//
//        $controller = $router->getController();
//        $action     = $router->getAction();
//
//        session_start();
//
//        // вызываем метод, если он существует
//        if (class_exists($controller) && method_exists($controller, $action)) {
//            (new $controller())->$action();
//        } else {
//            (new BaseController())->render('errors/404', []);
//        }
		$router = require(__DIR__ . '/../../config/routes.config.php');
		$router->run();
    }

    /**
     * @param string $url
     */
    public function redirect(string $url = '') : void
    {
        header("Location: /{$url}");
    }
}

