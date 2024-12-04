<?php

namespace app\controllers;

use app\core\View;

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
}
