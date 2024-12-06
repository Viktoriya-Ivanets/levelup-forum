<?php

namespace app\controllers;

use app\core\Router;
use app\models\Category;
use app\utils\CategoryValidation;
use app\utils\Helpers;

class CategoryController extends Controller
{
    protected CategoryValidation $validation;
    public function __construct()
    {
        parent::__construct('', new Category());
        $this->validation = new CategoryValidation();
    }

    /**
     * Generates categories page
     * @return void
     */
    public function index(): void
    {
        $categories = $this->model->getAll();
        $user = $this->getCurrentUser();
        $this->view->render('categories', compact('categories', 'user'));
    }

    /**
     * Shows create category page
     * @return void
     */
    public function create(): void
    {
        $this->view->render('category_add');
    }

    /**
     * Stores a new category
     * @return void
     */
    public function store(): void
    {
        $postData = $this->validation->getValidatedData(['title', 'description'], 'category_add');

        $user = $this->getCurrentUser();
        $postData['user_id'] = $user['id'];

        if (!$this->model->create($postData)) {
            Helpers::renderError('Category not created');
        }

        Router::redirect('categories');
    }

    /**
     * Shows edit category page
     * @param array $params id from URL
     * @return void
     */
    public function edit(array $params): void
    {
        $category = $this->model->findCategoryOrFail($params['id']);
        $this->view->render('category_edit', compact('category'));
    }

    /**
     * Updates an existing category
     * @return void
     */
    public function update(): void
    {
        $postData = $this->validation->getValidatedData(['id', 'title', 'description'], 'category_edit');

        $this->model->findCategoryOrFail($postData['id']);

        if (!$this->model->update($postData['id'], $postData)) {
            Helpers::renderError('Category not updated');
        }

        Router::redirect('categories');
    }

    /**
     * Deletes a category
     * @param array $params id from URL
     * @return never
     */
    public function delete(array $params): never
    {
        $category = $this->model->findCategoryOrFail($params['id']);

        if (!$this->model->delete($category['id'])) {
            Helpers::renderError('Category not deleted');
        }

        Router::redirect('categories');
    }
}
