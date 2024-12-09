<?php

namespace app\controllers;

use app\core\Router;
use app\core\Session;
use app\models\Category;
use app\utils\CategoryValidation;

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
    public function index(array $params): void
    {
        $categories = $this->enrichCategoriesWithUser($this->model->getLimitedCount($params['page'] - 1, PAGE_LIMIT));
        $pages = $this->countPages(10);

        $this->view->render('categories', compact('categories', 'pages'));
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
            $this->view->renderError(['message' => 'Category not created, please try again later', 'code' => 500]);
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
        $old = Session::get('old') ?? $this->findCategoryOrFail(end($params['ids']));
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
        $this->findCategoryOrFail($postData['id']);

        if (!$this->model->update($postData['id'], $postData)) {
            $this->view->renderError(['message' => 'Category not updated, please try again later', 'code' => 500]);
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
        $category = $this->findCategoryOrFail(end($params['ids']));

        if (!$this->model->delete($category['id'])) {
            $this->view->renderError(['message' => 'Category not deleted, please try again later', 'code' => 500]);
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
