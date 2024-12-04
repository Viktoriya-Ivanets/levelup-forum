<?php

namespace app\models;

use app\models\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * Get all needed user's data from DB by login
     * @param string $login
     * @return array|null
     */
    public function findUserByLogin(string $login): ?array
    {
        $query = "SELECT id, login, password FROM users WHERE login = ?";
        $result = $this->fetchOne($query, 's', [$login]);
        return $result ?? null;
    }
}
