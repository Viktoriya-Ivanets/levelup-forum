<?php

namespace app\controllers;

use app\core\View;

class CategoryController
{
    protected View $view;
    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Generates categories page
     * @return void
     */
    public function index(): void
    {
        $this->view->render('categories');
    }
}
