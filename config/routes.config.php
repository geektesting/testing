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

/**
 * Главная
 */
$router->get('/', 'Main@Index');

/**
 * Личный кабинет
 */

//	$router->before('GET|POST', '/account/.*', function() {
//		if (!isset($_SESSION['isAuth'])) {
//			header('location: /auth/login');
//		}
//	});
$router->get('/account', 'Account@Index');

/**
 * Авторизация/регистрация
 */
$router->any('/account/register', 'Account@Register');
$router->get('/auth', 'Auth@Index');
$router->any('/auth/login', 'Auth@Login');
$router->get('/auth/logout', 'Auth@Logout');

/**
 * Работа с категориями
 */
$router->party('/cats', function() use ($router) {
	$router->get('/', 'Cats@Index');
	$router->get('/create', 'Cats@Create');
	$router->get('/edit', 'Cats@Edit');
	$router->get('/editsave', 'Cats@Editsave');	// GET ??
	$router->get('/delete', 'Cats@Delete');		// GET ??
});

/**
 * Работа с вопросами
 */
$router->party('/qcats', function() use ($router) {
	$router->get('/', 'Qcats@Index');
	$router->get('/create', 'Qcats@Create');
	$router->get('/rename', 'Qcats@Rename');
	$router->get('/save', 'Qcats@Save');			// GET ??
	$router->get('/edit', 'Qcats@Edit');			// GET ??
	$router->get('/delete', 'Qcats@Delete');		// GET ??
});

/**
 * Работа с тестами
 */
$router->party('/quizes', function() use ($router) {
	$router->get('/', 'Quizes@Index');
	$router->get('/create', 'Quizes@Create');
	$router->post('/save', 'Quizes@Save');
	$router->get('/edit', 'Quizes@Edit');
	$router->get('/delete', 'Quizes@Delete');	// GET ??
});

return $router;