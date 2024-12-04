<?php

namespace app\controllers;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
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
