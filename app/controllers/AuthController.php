<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Auth;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Страница логина
     */
    public function actionIndex()
    {
        if ($this->isAuth()) {
            App::getInstance()->redirect(); // ToDo: account
            return;
        }

        $this->render("auth/login", [
            "title" => "Login page"
        ]);
    }

    /**
     * ToDo: Добавить поддержку Ajax запросов
     * Обработка формы авторизации
     */
    public function actionLogin()
    {
        if ($this->isAuth()) {
            App::getInstance()->redirect(); // ToDo: account
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {

            if ((new Auth())->login($_POST['login'], $_POST['pass'])) {
                App::getInstance()->redirect(); // ToDo: account
                return;
            }
        }
        // ToDo: Надо показывать ошибки вместо редиректа
        App::getInstance()->redirect('auth');
    }

    /**
     * Логаут
     */
    public function actionLogout()
    {
        if ($this->isAuth()) {
            (new Auth())->logout();
        }

        App::getInstance()->redirect();
    }

}