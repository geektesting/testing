<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 12:57
 */

namespace App;


use App\controllers\BaseController;

/**
 * Class Route
 * @package App
 */
class Route
{
    use Singleton;

    /**
     * @var array
     */
    private static $_getUri     = [];
    private static $_postUri    = [];
    private static $_putUri     = [];
    private static $_patchUri   = [];
    private static $_delUri     = [];
    private static $_optUri     = [];

    /**
     * Метод 'GET'
     * @param string $uri
     * @param string $method
     */
    public static function get(string $uri, string $method)
    {
        self::$_getUri[] = [$uri => $method];
    }

    /**
     * Метод 'POST'
     * @param string $uri
     * @param string $method
     */
    public static function post(string $uri, string $method)
    {
        self::$_postUri[] = [$uri => $method];
    }

    /**
     * Метод 'PUT'
     * @param string $uri
     * @param string $method
     */
    public static function put(string $uri, string $method)
    {
        self::$_putUri[] = [$uri => $method];
    }

    /**
     * Метод 'PATCH'
     * @param string $uri
     * @param string $method
     */
    public static function patch(string $uri, string $method)
    {
        self::$_patchUri[] = [$uri => $method];
    }

    /**
     * Метод 'DELETE'
     * @param string $uri
     * @param string $method
     */
    public static function delete(string $uri, string $method)
    {
        self::$_delUri[] = [$uri => $method];
    }

    /**
     * Метод 'OPTIONS'
     * @param string $uri
     * @param string $method
     */
    public static function options(string $uri, string $method)
    {
        self::$_optUri[] = [$uri => $method];
    }

    /**
     * Начинаем разбор URI
     */
    public function run(): void
    {

        // разные маршруты взависимости от метода
        switch ($_SERVER['REQUEST_METHOD'])
        {
            default:        $routesData = self::$_getUri;     break; // 'GET' по умолчанию
            case 'POST':    $routesData = self::$_postUri;    break;
            case 'PUT':     $routesData = self::$_putUri;     break;
            case 'PATCH':   $routesData = self::$_patchUri;   break;
            case 'DELETE':  $routesData = self::$_delUri;     break;
            case 'OPTIONS': $routesData = self::$_optUri;     break;
        }

        $requestedUri = $_SERVER['REQUEST_URI'];

        if ($requestedUri !== '/')
        {
            // разделяем uri по частям
            $uri = explode('?', $requestedUri);
            $requestedUri = urldecode(rtrim(reset($uri), '/'));
        }

        // проходимся по маршрутам
        foreach ($routesData as $routes)
        {
            foreach ($routes as $route => $method )
            {
                if (strpos($route, ':') !== false)
                {
                    $route = str_replace(':a', '(.+)',
                        str_replace(':n', '([0-9]+)',
                            str_replace(':s', '([a-zA-Z]+)',
                                $route
                            )
                        )
                    );
                }

                // если условия совпадают - заменяем регулярное значение на данные
                if (preg_match('#^'.$route.'$#', $requestedUri))
                {
                    if (strpos($method, '$') !== false && strpos($route, '(') !== false)
                    {
                        $route = preg_replace('#^'.$route.'$#', $method, $requestedUri);
                    } else {
                        $route = $method;
                    }

                    $uriParts = explode('@', $route);
                    $controller = 'App\\controllers\\' . array_shift($uriParts);
                    $args = explode('/', array_shift($uriParts));
                    $action = 'action'.ucfirst(array_shift($args));

                    // вызываем метод, если он существует
                    if (class_exists($controller) && method_exists($controller, $action))
                    {
                        call_user_func_array([(new $controller()), $action], [$args]);
                        return;
                    }
                }
            }
        }
        // В случае, если указанный метод недоступен
        // или запрашиваемый uri не найден - ыводим страницу с ошибкой
        (new BaseController())->render('errors/404', []);
    }
}