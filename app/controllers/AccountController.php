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
            $this->render("account/index", [
                "title" => "Account page",
                "user" => $user
            ]);
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
            App::getInstance()->redirect('account');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login']) && isset($_POST['pass'])
            && preg_match('/^[A-z0-9-_]{3,}$/',$_POST['login']) && strlen($_POST['pass']) > 5) {
            if (User::register($_POST['login'], $_POST['pass']) && (new Auth())->login($_POST['login'], $_POST['pass'])) {
                App::getInstance()->redirect('account');
                return;
            }

            // ToDo: Надо показывать ошибки
        }

        $this->render("account/register", [
            "title" => "Register user"
        ]);
    }
}