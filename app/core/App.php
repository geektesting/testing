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

		session_start();
		// Добавляем маршруты
		$router = require(__DIR__ . '/../../config/routes.config.php');
		// Запускаем роутер
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

