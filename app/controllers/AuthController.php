<?php

namespace app\controllers;

use app\core\Router;
use app\models\User;
use app\core\Session;
use app\utils\AuthValidation;
use app\utils\Helpers;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct('auth', new User());
    }

    /**
     * Handles user login.
     * Validates the credentials and logs in the user if successful.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($error = AuthValidation::validateLogin(Helpers::getPostData(['login', 'password', 'password_confirm']))) {
                $this->view->render('login', ['error' => $error]);
            }
            extract(Helpers::getPostData(['login', 'password']));

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

            if ($error = AuthValidation::validateRegister(Helpers::getPostData(['login', 'password', 'password_confirm']))) {
                $this->view->render('register', ['error' => $error]);
            }
            extract(Helpers::getPostData(['login', 'password', 'password_confirm']));

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
