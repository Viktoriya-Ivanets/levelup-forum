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
     * Fetches the current user from the session and returns it's id
     * @return int|null
     */
    protected function getCurrentUserId(): ?int
    {
        $userModel = new User();
        $user = $userModel->findUserByLogin(Session::get('user'));
        return $user['id'];
    }

    /**
     * Checks whether logged user is author of entity (category, topic, message)
     * @param int $id
     * @return bool
     */
    protected function isAuthor(int $id): bool
    {
        if ($this->getCurrentUserId() === $id) {
            return true;
        }
        return false;
    }
}
