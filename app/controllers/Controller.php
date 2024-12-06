<?php

namespace app\controllers;

use app\core\Session;
use app\core\View;
use app\models\User;

abstract class Controller
{
    protected View $view;
    protected ?object $model;

    /**
     * Constructor for the base controller.
     *
     * @param string $template The name of the template to use for views.
     * @param object|null $model The model instance to associate with the controller (optional).
     */
    public function __construct(string $template = '', ?object $model = null)
    {
        $this->view = new View($template);
        $this->model = $model ?? null;
    }

    /**
     * Fetches the current user from the session
     * @return array|null
     */
    protected function getCurrentUser(): ?array
    {
        $userModel = new User();
        return $userModel->findUserByLogin(Session::get('user'));
    }
}
