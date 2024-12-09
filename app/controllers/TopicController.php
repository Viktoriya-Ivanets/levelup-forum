<?php

namespace app\controllers;

use app\core\Router;
use app\core\Session;
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
     * Generates topics page
     * @param array $params
     * @return void
     */
    public function index(array $params): void
    {
        $categoryId = $this->checkCategory($params['ids'][0]);
        $topics = $this->enrichTopicsWithUser($this->model->getTopicsByCategory($categoryId));

        $this->view->render('topics', compact('categoryId', 'topics'));
    }

    /**
     * Renders topic's create form
     * @param array $params
     * @return void
     */
    public function create(array $params): void
    {
        $errors = Session::get('errors') ?? [];
        $old = Session::get('old') ?? [];
        if (!empty($errors)) {
            Session::remove(['errors', 'old']);
        }

        $categoryId = $this->checkCategory($params['ids'][0]);
        $this->view->render('topic_add', compact('categoryId', 'errors', 'old'));
    }

    /**
     * Stores a new topic
     * @param array $params
     * @return void
     */
    public function store(array $params): void
    {
        $postData = $this->validation->getValidatedData(['title', 'description']);

        if (!$postData) {
            Router::redirect('categories/' . $params['ids'][0] . '/topics/create');
        }

        $postData['user_id'] = $this->getCurrentUserId();
        $postData['category_id'] = $this->checkCategory($params['ids'][0]);

        if (!$this->model->create($postData)) {
            Helpers::renderError('Topic not created');
        }

        Router::redirect('categories/' . $postData['category_id'] . '/topics');
    }

    /**
     * Renders topic's edit form 
     * @param array $params
     * @return void
     */
    public function edit(array $params): void
    {
        $errors = Session::get('errors') ?? [];
        $old = Session::get('old') ?? $this->model->findTopicOrFail($params['ids'][1]);
        if (!empty($errors)) {
            Session::remove(['errors', 'old']);
        }

        $categoryId = $this->checkCategory($params['ids'][0]);

        $this->view->render('topic_edit', compact('categoryId', 'old', 'errors'));
    }

    /**
     * Updates an existing topic
     * @return void
     */
    public function update(array $params): void
    {
        $postData = $this->validation->getValidatedData(['id', 'title', 'description']);
        if (!$postData) {
            $topicId = Session::get('old')['id'];
            Router::redirect('categories/' . $params['ids'][0] . '/topics/edit/' . $topicId);
        }
        $this->model->findTopicOrFail($postData['id']);

        if (!$this->model->update($postData['id'], $postData)) {
            Helpers::renderError('Topic not updated');
        }

        Router::redirect('categories/' . $params['ids'][0] . '/topics');
    }

    /**
     * Delets existing topic
     * @param array $params
     * @return never
     */
    public function delete(array $params): never
    {
        $topic = $this->model->findTopicOrFail(end($params['ids']));
        $categoryId = $topic['category_id'];

        if (!$this->model->delete($topic['id'])) {
            Helpers::renderError('Topic not deleted');
        }

        Router::redirect('categories/' . $categoryId . '/topics');
    }

    /**
     * Adds needed fields to the topics for the correct view
     * @param array $topics
     * @return array
     */
    private function enrichTopicsWithUser(array $topics): array
    {
        $userModel = new User();
        foreach ($topics as &$topic) {
            $user = $userModel->getById($topic['user_id']);
            $topic['user_login'] = $user['login'];
            $topic['is_author'] = $this->isAuthor($topic['user_id']);
        }
        unset($topic);
        return $topics;
    }
}
