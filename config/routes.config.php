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
	$router->get('/save', 'Cats@Save');
	$router->get('/edit', 'Cats@Edit');
	$router->get('/editsave', 'Cats@Editsave');	// GET ??
	$router->get('/delete', 'Cats@Delete');		// GET ??
});

/**
 * Работа с категориями вопросов
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
	$router->get('/add', 'Quizes@Add');
	$router->get('/delete', 'Quizes@Delete');	// GET ??
});

/**
 * Работа с вопросами
 */
$router->party('/questions', function() use ($router) {
	$router->get('/', 'Questions@Index');
	$router->get('/create', 'Questions@Create');
	$router->post('/save', 'Questions@Save');
	$router->get('/edit', 'Questions@Edit');
	$router->post('/add', 'Questions@Add');
	$router->get('/delete', 'Questions@Delete');
	$router->post('/toggle', 'Questions@Toggle');
});

/**
 * Отображение отдельного теста
 */
$router->party('/quiz', function() use ($router) {
	$router->get('/', 'Quiz@Index');
	$router->get('/run', 'Quiz@Run');
	$router->post('/questions', 'Quiz@Questions');
	$router->post('/render', 'Quiz@Render');	
});

/**
 * Отображение содержимого категории тестов
 */
$router->party('/cat', function() use ($router) {
	$router->get('/', 'Cat@Index');
});

return $router;