<?php

namespace App\Models\Rep;

use App\Models\User;

/**
 * Class UserRep
 * @package App\Models\Rep
 */
class UserRep extends AbstractRep
{
    protected $nestedClass = 'App\Models\User';

    /**
     * @param string $login
     * @param string $pass
     * @return User
     */
    public function getByLoginPass(string $login, string $pass)
    {
        return $this->db->fetchObject(
            "SELECT u.* FROM users u
             WHERE login = ? AND password = ?", [$login, md5($pass)], $this->nestedClass
        );
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id)
    {
        return $this->db->fetchObject(
            "SELECT u.* FROM users u WHERE u.id = ?", [$id],  $this->nestedClass
        );
    }
}