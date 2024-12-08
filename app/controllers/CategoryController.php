<?php

namespace app\controllers;

use app\core\Router;
use app\core\Session;
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
        $categories = $this->enrichCategoriesWithUser($this->model->getAll());
        $this->view->render('categories', compact('categories'));
    }

    /**
     * Shows create category page
     * @return void
     */
    public function create(): void
    {
        $errors = Session::get('errors') ?? [];
        $old = Session::get('old') ?? [];
        if (!empty($errors)) {
            Session::remove(['errors', 'old']);
        }

        $this->view->render('category_add', compact('errors', 'old'));
    }

    /**
     * Stores a new category
     * @return void
     */
    public function store(): void
    {
        $postData = $this->validation->getValidatedData(['title', 'description']);

        if (!$postData) {
            Router::redirect('categories/create');
        }

        $postData['user_id'] = $this->getCurrentUserId();

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
        $errors = Session::get('errors') ?? [];
        $old = Session::get('old') ?? $this->model->findCategoryOrFail(end($params['ids']));
        if (!empty($errors)) {
            Session::remove(['errors', 'old']);
        }
        $this->view->render('category_edit', compact('errors', 'old'));
    }

    /**
     * Updates an existing category
     * @return void
     */
    public function update(): void
    {
        $postData = $this->validation->getValidatedData(['id', 'title', 'description']);

        if (!$postData) {
            $categoryId = Session::get('old')['id'];
            Router::redirect('categories/edit/' . $categoryId);
        }
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
        $category = $this->model->findCategoryOrFail(end($params['ids']));

        if (!$this->model->delete($category['id'])) {
            Helpers::renderError('Category not deleted');
        }

        Router::redirect('categories');
    }

    /**
     * Adds is_author field to category for correct view displaying
     * @param array $categories
     * @return array
     */
    private function enrichCategoriesWithUser(array $categories): array
    {
        foreach ($categories as &$category) {
            $category['is_author'] = $this->isAuthor($category['user_id']);
        }
        unset($category);
        return $categories;
    }
}
