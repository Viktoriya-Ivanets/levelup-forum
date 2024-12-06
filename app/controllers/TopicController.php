<?php

namespace app\controllers;

use app\core\Router;
use app\models\Category;
use app\models\Topic;
use app\models\User;
use app\utils\TopicValidation;
use app\utils\Helpers;

class TopicController extends Controller
{
    protected TopicValidation $validation;
    public function __construct()
    {
        parent::__construct('', new Topic());
        $this->validation = new TopicValidation();
    }

    /**
     * Generates categories page
     * @param array $params
     * @return void
     */
    public function index(array $params): void
    {
        $user = $this->getCurrentUser();
        $categoryModel = new Category();
        $category = $categoryModel->findCategoryOrFail($params['id']);
        $topics = $this->model->getTopicsByCategory($category['id']);
        $userModel = new User();
        foreach ($topics as &$topic) {
            $user = $userModel->getById($topic['user_id']);
            $topic['user_login'] = $user['login'];
        }
        unset($topic);

        $this->view->render('topics', compact('category', 'topics', 'user'));
    }

    /**
     * Shows create topic page
     * @param array $params
     * @return void
     */
    public function create(array $params): void
    {
        $categoryModel = new Category();
        $category = $categoryModel->findCategoryOrFail($params['id']);
        $this->view->render('topic_add', ['category' => $category]);
    }

    /**
     * Stores a new topic
     * @return void
     */
    public function store(): void
    {
        $postData = $this->validation->getValidatedData(['title', 'description', 'category_id'], 'topic_add');

        $user = $this->getCurrentUser();
        $postData['user_id'] = $user['id'];

        $categoryModel = new Category();
        $category = $categoryModel->findCategoryOrFail($postData['category_id']);
        $postData['category_id'] = $category['id'];

        if (!$this->model->create($postData)) {
            Helpers::renderError('Topic not created');
        }

        Router::redirect('categories/' . $category['id'] . '/topics');
    }

    /**
     * Renders topic's edit form 
     * @param array $params
     * @return void
     */
    public function edit(array $params): void
    {
        $topic = $this->model->findTopicOrFail($params['id']);
        $this->view->render('topic_edit', compact('topic'));
    }

    /**
     * Updates an existing topic
     * @return void
     */
    public function update(): void
    {
        $postData = $this->validation->getValidatedData(['id', 'title', 'description', 'category_id'], 'topic_edit');

        $this->model->findTopicOrFail($postData['id']);

        if (!$this->model->update($postData['id'], $postData)) {
            Helpers::renderError('Topic not updated');
        }

        Router::redirect('categories/' . $postData['category_id'] . '/topics');
    }

    /**
     * Delets existing topic
     * @param array $params
     * @return never
     */
    public function delete(array $params): never
    {
        $topic = $this->model->findTopicOrFail($params['id']);
        $category_id = $topic['category_id'];

        if (!$this->model->delete($topic['id'])) {
            Helpers::renderError('Topic not deleted');
        }

        Router::redirect('categories/' . $category_id . '/topics');
    }
}
