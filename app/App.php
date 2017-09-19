<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:12
 */

namespace core;
use core\controllers\MainController;

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
        // Вызываем тестовый метод actionIndex класса MainController
        $m = new MainController();
        $m->actionIndex();
    }
}