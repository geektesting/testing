<?php
namespace App\Models;

use App\Models\Rep\SessionsRep;
use App\Models\Rep\UserRep;

/**
 * Class Auth
 * @package App\Core
 */
class Auth
{
    protected $sessionKey = 'sid';

    /**
     * Выход из сессии
     */
    public function logout()
    {
        $sid =  isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : null;
        if(!is_null($sid)) {
            $model = new SessionsRep();
            $model->dropSession($sid);
            unset($_SESSION[$this->sessionKey]);
        }
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login(string $login, string $password) : bool
    {
        $user = (new UserRep())->getByLoginPass($login, $password);
        if (!$user) {
            return false;
        }
        return $this->openSession($user);
    }

    /**
     * @return null
     */
    public function getSessionId()
    {
        $sid =  isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : null;
        if(!is_null($sid)){
            (new SessionsRep())->updateLastTime($sid);
        }        
        return $sid;
    }

    /**
     * @param User $user
     * @return bool
     */
    protected function openSession(User $user) : bool
    {
        $model = new SessionsRep();
        $sid = $this->generateStr();
        $model->createNew($user->getId(),$sid, date("Y-m-d H:i:s"));
        $_SESSION[$this->sessionKey] = $sid;
        return true;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateStr(int $length = 32) : string
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length)
            $code .= $chars[mt_rand(0, $clen)];

        return $code;
    }
}