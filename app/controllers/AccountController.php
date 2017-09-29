<?php

namespace App\Controllers;

use App\Models\User;
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
    public function actionIndex() : void
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
}