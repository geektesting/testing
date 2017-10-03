<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 03.10.2017
 * Time: 13:58
 */

use \App\Core\Router;

$router = new Router();

$router->set404(function () {
	echo '404 страница не найдена!';
});

$router->get('/', 'Main@Index');
$router->get('/about', 'Main@About');

/**
 * Авторизация/регистрация
 */
$router->get( '/account', 'Account@Index');
$router->get( '/auth', 'Auth@Index');
$router->match('GET|POST', '/account/register', 'Account@Register');
$router->match('GET|POST', '/auth/login', 'Auth@Login');
$router->get('/auth/logout', 'Auth@Logout');

/**
 * Работа с категориями
 */
$router->get('/cats', 'Cats@Index');
$router->get('/cats/edit', 'Cats@Edit');
$router->get('/cats/editsave', 'Cats@Editsave');		// GET ??
$router->get('/cats/delete', 'Cats@Delete');			// GET ??

/**
 * Работа с вопросами
 */
$router->get('/qcats', 'Qcats@Index');
$router->get('/qcats/create', 'Qcats@Create');
$router->get('/qcats/save', 'Qcats@Save'); 			// GET ??
$router->get('/qcats/edit', 'Qcats@Edit');			// GET ??
$router->get('/qcats/delete', 'Qcats@Delete');		// GET ??

/**
 * Работа с тестами
 */
$router->get('/quizes', 'Quizes@Index');
$router->get('/quizes/create', 'Quizes@Create');
$router->post('/quizes/save', 'Quizes@Save');
$router->get('/quizes/edit', 'Quizes@Edit');
$router->get('/quizes/delete', 'Quizes@Delete');		// GET ??

return $router;