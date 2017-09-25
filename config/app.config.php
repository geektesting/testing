<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:02
 */

use \App\Config;

// Имя приложения
Config::$app["NAME"]        = "Testing Framework";
// настройки директорий
Config::$app["VIEWS"]       = $_SERVER["DOCUMENT_ROOT"]."/../app/views/";

// Настройки БД
Config::$db["DB_DRIVER"]    = "mysql"; // драйвер БД
Config::$db["DB_HOST"]      = "127.0.0.1"; // сервер БД
Config::$db["DB_USER"]      = "root"; // логин
Config::$db["DB_PASS"]      = ""; // пароль
Config::$db["DB_NAME"]      = "oleg_bolden"; // имя БД

// Настройки роутинга
Config::$router = [
    'about'                    => 'main@about',
    '{controller}/{action}'    => '{controller}@{action}',
];
