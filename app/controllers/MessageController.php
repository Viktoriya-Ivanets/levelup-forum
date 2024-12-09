<?php

namespace app\controllers;

use app\core\Router;
use app\core\Session;
use app\models\Message;
use app\models\User;
use app\utils\Helpers;
use app\utils\MessageValidation;

class MessageController extends Controller
{
    protected MessageValidation $validation;
    public function __construct()
    {
        parent::__construct('', new Message());
        $this->validation = new MessageValidation();
    }

    /**
     * Generates messages page
     * @param array $params
     * @return void
     */
    public function index(array $params): void
    {
        $categoryId = $this->findCategoryOrFail($params['ids'][0])['id'];
        $topic = $this->findTopicOrFail($params['ids'][1]);
        $topic['user_login'] = (new User())->getById($topic['user_id'])['login'];
        $topic['date'] = Helpers::getDate($topic['created_at']);
        $topic['time'] = Helpers::getTime($topic['created_at']);
        $messages = $this->enrichMessagesWithUser($this->model->getAll());

        $this->view->render('topic', compact('categoryId', 'topic', 'messages'));
    }

    /**
     * Renders message's create form
     * @param array $params
     * @return void
     */
    public function create(array $params): void
    {
        $categoryId = $this->findCategoryOrFail($params['ids'][0])['id'];
        $topicId = $this->findTopicOrFail($params['ids'][1])['id'];
        $errors = Session::get('errors') ?? [];
        $old = Session::get('old') ?? [];
        if (!empty($errors)) {
            Session::remove(['errors', 'old']);
        }

        $this->view->render('message_add', compact('categoryId', 'topicId', 'errors', 'old'));
    }

    /**
     * Stores a new message
     * @param array $params
     * @return void
     */
    public function store(array $params): void
    {
        $categoryId = $this->findCategoryOrFail($params['ids'][0])['id'];
        $topicId = $this->findTopicOrFail($params['ids'][1])['id'];
        $postData = $this->validation->getValidatedData(['text']);

        if (!$postData) {
            Router::redirect('categories/' . $categoryId . '/topics/' . $topicId . '/messages/create');
        }

        $postData['user_id'] = $this->getCurrentUserId();
        $postData['topic_id'] = $topicId;

        if (!$this->model->create($postData)) {
            $this->view->renderError(['message' => 'Message not created, please try again later', 'code' => 500]);
        }

        Router::redirect('categories/' . $categoryId . '/topics/' . $topicId . '/messages');
    }

    /**
     * Renders message's edit form 
     * @param array $params
     * @return void
     */
    public function edit(array $params): void
    {
        $categoryId = $this->findCategoryOrFail($params['ids'][0])['id'];
        $topicId = $this->findTopicOrFail($params['ids'][1])['id'];
        $errors = Session::get('errors') ?? [];
        $old = Session::get('old') ?? $this->findMessageOrFail(end($params['ids']));
        if (!empty($errors)) {
            Session::remove(['errors', 'old']);
        }

        $this->view->render('message_edit', compact('categoryId', 'topicId', 'old', 'errors'));
    }

    /**
     * Updates an existing message
     * @return void
     */
    public function update(array $params): void
    {
        $categoryId = $this->findCategoryOrFail($params['ids'][0])['id'];
        $topicId = $this->findTopicOrFail($params['ids'][1])['id'];
        $postData = $this->validation->getValidatedData(['id', 'text']);

        if (!$postData) {
            $messageId = Session::get('old')['id'];
            Router::redirect('categories/' . $categoryId . '/topics/' . $topicId . '/messages/edit/' . $messageId);
        }

        $this->findMessageOrFail($postData['id']);

        if (!$this->model->update($postData['id'], $postData)) {
            $this->view->renderError(['message' => 'Message not updated, please try again later', 'code' => 500]);
        }

        Router::redirect('categories/' . $categoryId . '/topics/' . $topicId . '/messages');
    }

    /**
     * Delets existing message
     * @param array $params
     * @return never
     */
    public function delete(array $params): never
    {
        $categoryId = $this->findCategoryOrFail($params['ids'][0])['id'];
        $topicId = $this->findTopicOrFail($params['ids'][1])['id'];
        $message = $this->findMessageOrFail(end($params['ids']));

        if (!$this->model->delete($message['id'])) {
            $this->view->renderError(['message' => 'Message not deleted, please try again later', 'code' => 500]);
        }

        Router::redirect('categories/' . $categoryId . '/topics/' . $topicId . '/messages');
    }

    /**
     * Adds needed fields to the messages for the correct view
     * @param array $messages
     * @return array
     */
    private function enrichMessagesWithUser(array $messages): array
    {
        $userModel = new User();
        foreach ($messages as &$message) {
            $user = $userModel->getById($message['user_id']);
            $message['user_login'] = $user['login'];
            $message['is_author'] = $this->isAuthor($message['user_id']);
            $message['time'] = Helpers::getTime($message['created_at']);
        }
        unset($message);
        return $messages;
    }
}
