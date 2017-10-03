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

//	$router->before('GET|POST', '/account/.*', function() {
//		if (!isset($_SESSION['isAuth'])) {
//			header('location: /auth/login');
//		}
//	});
$router->get( '/account', 'Account@Index');
$router->get( '/auth', 'Auth@Index');
$router->match('GET|POST', '/account/register', 'Account@Register');
$router->match('GET|POST', '/auth/login', 'Auth@Login');
$router->get('/auth/logout', 'Auth@Logout');

/**
 * Работа с категориями
 */
$router->party('/cats', function() use ($router) {
	$router->get('/', 'Cats@Index');
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
	$router->get('/save', 'Qcats@Save'); 		// GET ??
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