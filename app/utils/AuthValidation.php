<?php

namespace app\utils;

use app\models\User;

class AuthValidation
{
    /**
     * Validates user login information.
     *
     * @param array $user The user data, including 'login' and 'password'.
     * @return bool|string Returns false if validation passes, otherwise a string with an error message.
     */
    public static function validateLogin(array $user): bool|string
    {
        $model = new User();
        if (empty($user['login']) || empty($user['password'])) {
            return 'Fields cannot be empty';
        }

        $existingUser = $model->findUserByLogin($user['login']);
        if (!$existingUser) {
            return 'User with such login does not exist';
        }

        if (!password_verify($user['password'], $existingUser['password'])) {
            return 'Incorrect password';
        }

        return false;
    }

    /**
     * Validates user registration information.
     *
     * @param array $user The user data, including 'login', 'password', and 'password_confirm'.
     * @return bool|string Returns false if validation passes, otherwise a string with an error message.
     */
    public static function validateRegister(array $user): bool|string
    {
        $model = new User();
        if (empty($user['login']) || empty($user['password']) || empty($user['password_confirm'])) {
            return 'Fields cannot be empty';
        }

        $existingUser = $model->findUserByLogin($user['login']);
        if ($existingUser) {
            return 'User with such login already exist';
        }

        if ($user['password'] != $user['password_confirm']) {
            return 'Passwords do not match';
        }

        return false;
    }
}
