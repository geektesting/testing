<?php

// Включаем режим строгой типизации
declare(strict_types=1);

// Подключаем автозагрузчик
require_once('../vendor/autoload.php');

// Запускаем приложение
\App\Core\App::getInstance()->run();