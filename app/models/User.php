<?php
namespace App\Models;

use App\Models\Rep\SessionsRep;
use App\Models\Rep\UserRep;

/**
 * Class User
 * @package App\Models
 */
class User
{
    protected $id;
    protected $login;
    protected $password;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return User|null
     */
    public function getCurrent()
    {
        $userId = $this->getUserId();
        if($userId){
            return (new UserRep())->getById($userId);
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    protected function getUserId()
    {
        $sid = (new Auth())->getSessionId();
        if(!is_null($sid)){
            return (new SessionsRep())->getUidBySid($sid);
        }
        return null;
    }

    /**
     * @param string $login
     * @param string $pass
     * @return bool
     */
    public static function register(string $login, string $pass) : bool
    {
        $userRep = new UserRep();
        $user = $userRep->getByLogin($login);

        if ($user) {
            return false;
        }

        return $userRep->create($login, $pass);
    }
}