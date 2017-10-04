<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 12:57
 */

namespace App\Core;

/**
 * Class Router
 * @package Core
 */
class Router
{
	/**
	 * @var array
	 */
	private $_routes = [];
	/**
	 * @var array
	 */
	private $_beforeRoutes = [];
	/**
	 * @var object|callable
	 */
	protected $notFoundCallback;
	/**
	 * @var string базовый маршрут (используется для группы маршрутов)
	 */
	private $_baseRoute = '';
	/**
	 * @var string метод запроса
	 */
	private $_requestedMethod = '';
	/**
	 * @var string
	 */
	private $_serverBasePath;

	/**
	 * Функция, которая должны быть выполнена в первую очередь (например, проверка прав доступа к ресурсу)
	 *
	 * @param string $methods разрешённые методы, | - разделитель
	 * @param string $pattern - шаблон типа `/user/info`
	 * @param object|callable $fn
	 */
	public function before($methods, $pattern, $fn) : void
	{
		$pattern = $this->_baseRoute . '/' . trim($pattern, '/');
		$pattern = $this->_baseRoute ? rtrim($pattern, '/') : $pattern;
		foreach (explode('|', $methods) as $method) {
			$this->_beforeRoutes[$method][] = [
				'pattern' => $pattern,
				'fn' => $fn
			];
		}
	}

	/**
	 * Маршруты, работающие с несколькими методами одновременно
	 *
	 * @param string $methods разрешённые методы, | - разделитель
	 * @param string $pattern - шаблон типа `/user/info`
	 * @param object|callable $fn
	 */
	public function match($methods, $pattern, $fn) : void
	{
		$pattern = $this->_baseRoute . '/' . trim($pattern, '/');
		$pattern = $this->_baseRoute ? rtrim($pattern, '/') : $pattern;
		foreach (explode('|', $methods) as $method) {
			$this->_routes[$method][] = [
				'pattern' => $pattern,
				'fn' => $fn
			];
		}
	}
	/**
	 * Любой метод
	 *
	 * @param string $pattern - шаблон типа `/user/info`
	 * @param object|callable $fn
	 */
	public function any($pattern, $fn) : void
	{
		$this->match('GET|POST', $pattern, $fn);
	}
	/**
	 * Метод GET
	 *
	 * @param string $pattern - шаблон типа `/user/info`
	 * @param object|callable $fn
	 */
	public function get($pattern, $fn) : void
	{
		$this->match('GET', $pattern, $fn);
	}
	/**
	 * Метод POST
	 *
	 * @param string $pattern - шаблон типа `/user/info`
	 * @param object|callable $fn
	 */
	public function post($pattern, $fn) : void
	{
		$this->match('POST', $pattern, $fn);
	}

	/**
	 * Группировка маршрутов
	 *
	 * @param string $_baseRoute - главный маршрут для группы
	 * @param callable $fn
	 */
	public function party($_baseRoute, $fn) : void
	{
		// Сохраняем текущий базовый маршрут
		$cur_baseRoute = $this->_baseRoute;
		// Создаём новый
		$this->_baseRoute .= $_baseRoute;
		// Вызываем функцию
		call_user_func($fn);
		// Восстанавливаем базовый маршрут
		$this->_baseRoute = $cur_baseRoute;
	}

	/**
	 * Получаем все заголовки запроса
	 *
	 * @return array
	 */
	public function getRequestHeaders() : array
	{
		$headers = [];
		foreach ($_SERVER as $name => $value) {
			if ((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')) {
				$headers[str_replace([' ', 'Http'], ['-', 'HTTP'], ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
	/**
	 * Получаем метод запроса
	 *
	 * @return string The Request method to handle
	 */
	public function getRequestMethod() : string
	{
		$method = $_SERVER['REQUEST_METHOD'];
		// Если это метод HEAD, то переопределяем его как GET и предотвращаем любой вывод,
		// в соответствии со спецификацией (http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4)
		if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
			ob_start();
			$method = 'GET';
		}
		return $method;
	}
	/**
	 * Запускаем роутер: проходимся по посредникам и маршрутам, и, если найдено совпадение, вызываем функцию
	 *
	 * @return bool
	 */
	public function run() : bool
	{
		// Определяем метод
		$this->_requestedMethod = $this->getRequestMethod();

		// Запускаем всех посредников, которые должны быть выполнены в первую очередь
		if (isset($this->_beforeRoutes[$this->_requestedMethod])) {
			$this->handle($this->_beforeRoutes[$this->_requestedMethod]);
		}

		// Определяем маршрут
		$matched = FALSE;
		if (isset($this->_routes[$this->_requestedMethod])) {
			$matched = $this->handle($this->_routes[$this->_requestedMethod]);
		}

		// Если ни один маршрут не найден - выводим 404 ошибку
		if ($matched === FALSE) {
			if ($this->notFoundCallback && is_callable($this->notFoundCallback)) {
				call_user_func($this->notFoundCallback);
			} else {
				header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
			}
		}

		// Если метод HEAD - очищаем буфер
		if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
			ob_end_clean();
		}

		return $matched;
	}
	/**
	 * Кастомизация ошибки 404
	 *
	 * @param object|callable $fn - функция для вызова
	 */
	public function set404($fn)
	{
		$this->notFoundCallback = $fn;
	}
	/**
	 * Определяем маршрут: если найдено совпадение - вызываем функцию
	 *
	 * @param array $routes - коллекция маршрутов и функций
	 * @return bool возвращаем true, если маршрут найден
	 */
	private function handle($routes) : bool
	{
		$matched = FALSE;

		// Текущий URL
		$uri = $this->getCurrentUri();

		// Проходимся по маршрутам
		foreach ($routes as $route) {
			// если найдено совпадение
			if (preg_match_all('#^' . $route['pattern'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
				$matches = array_slice($matches, 1);

				// Извлекаем параметры URL
				$params = array_map(function ($match, $index) use ($matches) {
					// Если у нас есть ещё один параметр
					if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
						return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
					} // Вернём всё, если у нас нет дополнительных параметров
					else {
						return (isset($match[0][0]) ? trim($match[0][0], '/') : NULL);
					}
				}, $matches, array_keys($matches));

				// Если объект, относящийся к маршруту, является функцией, то вызываем её
				if (is_callable($route['fn'])) {
					call_user_func_array($route['fn'], $params);
				} // Если это не функция, то пытаемся разбить на составные
				elseif (stripos($route['fn'], '@') !== FALSE) {
					// Разбиваем на части объект маршрута
					list($controller, $method) = explode('@', $route['fn']);

					// Правильно именуем название класса и его метод
					$controller = 'App\\controllers\\' . ucfirst($controller) . 'Controller';
					$method = 'action' . $method;

					// Проверяем, можем ли вы вызвать данный метод
					if (class_exists($controller)) {
						// Сначала проверям, является ли метод статическим, и если это действительно так - вызываем его как статический
						if (call_user_func_array([new $controller, $method], $params) === FALSE) {
							// В противном случае - это обычный метод
							if (forward_static_call_array([$controller, $method], $params) === FALSE) { };
						}
					}
				}
				$matched = TRUE;
				break;
			}
		}
		return $matched;
	}
	/**
	 * Определяем текущий URI
	 *
	 * @return string
	 */
	protected function getCurrentUri() : string
	{
		$uri = substr($_SERVER['REQUEST_URI'], strlen($this->getBasePath()));
		if (strstr($uri, '?')) {
			$uri = substr($uri, 0, strpos($uri, '?'));
		}
		return '/' . trim($uri, '/');
	}
	/**
	 * Определяем и возвращаем базовый путь
	 *
	 * @return string
	 */
	protected function getBasePath() : string
	{
		if ($this->_serverBasePath === NULL) {
			$this->_serverBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		}
		return $this->_serverBasePath;
	}
}