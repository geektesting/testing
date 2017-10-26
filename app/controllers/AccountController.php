<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Auth;
use App\Core\App;

/**
 * Class AccountController
 * @package App\Controllers
 */
class AccountController extends BaseController
{
    /**
     * Страница личного кабинета
     */
    public function actionIndex()
    {
        if ($user = (new User())->getCurrent()) {
            App::getInstance()->redirect(); // ToDo: account
            return;
            /*$this->render("account/index", [
                "title" => "Account page",
                "user" => $user
            ]);*/
        } else {
            App::getInstance()->redirect('auth');
        }
    }

    /**
     * Страница регистрации
     */
    public function actionRegister()
    {
        if ($this->isAuth()) {
            App::getInstance()->redirect(); // ToDo: account
            return;
        }

        $message = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['e_mail'])
                && preg_match('/^[A-z0-9-_]{3,}$/', $_POST['login']) && strlen($_POST['pass']) > 5
                && preg_match('/^[A-z0-9A-z._%+-]+@[A-z0-9.-]+\.[A-z]{2,64}$/', $_POST['e_mail'])) {
                if (User::register($_POST['login'], $_POST['pass'], $_POST['e_mail']) && (new Auth())->login($_POST['login'], $_POST['pass'])) {
                    App::getInstance()->redirect(); // ToDo: account
                    return;
                } else
                    $message = "Регистрация не удалась. Возможно пользователь с таким логином или почтой уже существует.";
            } else
                $message = "Неверные данные. Проверьте корректность заполнения полей.";
        }

        $this->render("account/register", [
            "title" => "Register user",
            "error" => $message
        ]);
    }
}