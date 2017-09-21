<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:12
 */

namespace App;

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
        (new Route())->run();
    }
}