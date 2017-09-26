<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:02
 */

use \App\Config;

// Подключаем файл переменных окружения
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

// Имя приложения
Config::$app["NAME"]        = "Testing Framework";
// настройки директорий
Config::$app["VIEWS"]       = $_SERVER["DOCUMENT_ROOT"]."/../app/views/";

// Настройки БД
Config::$db["DB_DRIVER"]    = "mysql"; // драйвер БД
Config::$db["DB_HOST"]      = $_ENV["DB_HOST"]; // сервер БД
Config::$db["DB_USER"]      = $_ENV["DB_USER"]; // логин
Config::$db["DB_PASS"]      = $_ENV["DB_PASS"]; // пароль
Config::$db["DB_NAME"]      = $_ENV["DB_NAME"]; // имя БД

// Настройки роутинга
Config::$router = [
    'about'                    => 'main@about',
    '{controller}/{action}'    => '{controller}@{action}',
];
