<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 1:02
 */


/**
 * Файл конфигурации приложения
 */
class Config {
    public static $app;
    public static $db;
    public static $router;
}

// Имя приложения
Config::$app["NAME"] = "Testing Framework";
// настройки директорий
Config::$app["VIEWS"] = $_SERVER["DOCUMENT_ROOT"]."/../app/views/";

// Настройки БД
Config::$db["DB_DRIVER"] = "mysql"; // драйвер БД
Config::$db["DB_HOST"] = "localhost"; // сервер БД
Config::$db["DB_USER"] = "user"; // логин
Config::$db["DB_PASS"] = "password"; // пароль
Config::$db["DB_NAME"] = "geektesting"; // имя БД

// Настройки роутинга
Config::$router = [
    '{controller}/{action}'    => '{controller}@{action}',
    'about'                    => 'main@about',
    ''                         => 'main@index'
];
