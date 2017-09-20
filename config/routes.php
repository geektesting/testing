<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 12:58
 */

use \App\Route;

/**
 * Создание маршрутов
 *
 * -------------------------------------------------
 * HTTP Методы:
 * -------------------------------------------------
 * Route::get()     - метод 'GET'
 * Route::post()    - метод 'POST'
 * Route::put()     - метод 'PUT'
 * Route::patch()   - метод 'PATCH'
 * Route::delete()  - метод 'DELETE'
 * Route::options() - метод 'OPTIONS'
 *
 * -------------------------------------------------
 * Маршруты и методы для вызова:
 * -------------------------------------------------
 * Route::get('/', 'MainController@index')
 * '/' - маршрут
 * 'MainController@index' - название контроллера и метода, которые будут вызваны
 * MainController - имя контроллера
 * index в процессе разбора роутером будет переименован в actionIndex() : MainController->actionIndex()
 *
 * -------------------------------------------------
 * Нативные регулярные выражения:
 * -------------------------------------------------
 * Подставляемые значения в маршруты
 * :n   |   целое число        |    ([0-9]+)
 * :s   |   строка             |    ([a-zA-Z]+)
 * :a   |   любое значение     |    (.+)
 * Пример:
 * Route::get('/numbers/:n/:n', 'MainController@number/$1/$2');
 * В процессе разбора URI роутером валидными будут только те маршруты,
 *  которые удовлетворяют условию (/number/123, /number/55555 ...)
 *  затем, данные значения будут доставлены до метода actionNumber() в виде простого массива в том порядке,
 *  в котором их указать в маршруте
 * Здесь важно запомнить, что все значения должны быть разделены слешем '/'
 */

Route::get('/', 'MainController@index');
Route::get('/numbers/:n', 'MainController@number/$1');
Route::get('/numbers/:n/:n', 'MainController@number/$1/$2');
Route::get('/about', 'MainController@about');

// Route::post('/login', 'UserController@postLogin');
// Route::put('/user/:n', 'UserController@putUser/$1');