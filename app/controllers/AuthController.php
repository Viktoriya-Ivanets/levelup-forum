<?php

namespace app\controllers;

use app\core\Router;
use app\core\View;
use app\models\User;
use app\core\Session;
use app\utils\Helpers;

class AuthController
{
    protected View $view;
    protected User $model;

    public function __construct()
    {
        $this->view = new View('auth');
        $this->model = new User();
    }

    /**
     * Handles user login.
     * Validates the credentials and logs in the user if successful.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract(Helpers::getPostData(['login', 'password']));

            $user = $this->model->findUserByLogin($login);

            if (!$user) {
                $this->view->render('login', ['error' => 'User with such login does not exist']);
            }
            if (!password_verify($password, $user['password'])) {
                $this->view->render('login', ['error' => 'Incorrect password']);
            }

            self::proceed(Session::generateToken(), $login);
        }

        $this->view->render('login');
    }

    /**
     * Handles user registration.
     * Validates the input and registers a new user if successful.
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract(Helpers::getPostData(['login', 'password', 'password_confirm']));

            if ($this->model->findUserByLogin($login)) {
                $this->view->render('register', ['error' => 'User with such login already exist']);
            }

            if ($password != $password_confirm) {
                $this->view->render('register', ['error' => 'Passwords do not match']);
            }

            $data = [
                'login' => $login,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
            $success = $this->model->create($data);

            if (!$success) {
                $this->view->render('register', ['error' => 'Something went wrong']);
            }

            self::proceed(Session::generateToken(), $login);
        }
        $this->view->render('register');
    }

    /**
     * Logs out the current user and redirects to the login page.
     */
    public function logout(): never
    {
        Session::destroy();
        Router::redirect('login');
    }

    /**
     * Proceeds with user login.
     * Sets session variables and redirects to the home page.
     *
     * @param string $token The generated session token.
     * @param string $login The user's login.
     */
    protected static function proceed(string $token, string $login): void
    {
        Session::set('token', $token);
        Session::set('user', $login);
        Router::redirect('');
    }
}
