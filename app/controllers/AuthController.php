<?php

namespace app\controllers;

use app\core\View;

class AuthController
{
    protected View $view;
    public function __construct()
    {
        $this->view = new View('auth');
    }
    public function login()
    {
        $this->view->render('login');
    }

    public function register()
    {
        $this->view->render('register');
    }
}
