<?php

namespace app\controllers;

use app\core\Session;
use app\core\View;
use app\models\Category;
use app\models\Message;
use app\models\Topic;
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
    /**
     * Finds a category by ID or throws an error
     * @param int $id
     * @return array
     */
    public function findCategoryOrFail(int $id): array
    {
        $category = (new Category())->getById($id);
        if (!$category) {
            $this->view->renderError(['message' => 'Category not found, please return back', 'code' => 404]);
        }
        return $category;
    }

    /**
     * Finds a topic by ID or throws an error
     * @param int $id
     * @return array
     */
    public function findTopicOrFail(int $id): array
    {
        $topic = (new Topic())->getById($id);
        if (!$topic) {
            $this->view->renderError(['message' => 'Topic not found, please return back', 'code' => 404]);
        }
        return $topic;
    }

    /**
     * Finds a message by ID or throws an error
     * @param int $id
     * @return array
     */
    public function findMessageOrFail(int $id): array
    {
        $message = (new Message())->getById($id);
        if (!$message) {
            $this->view->renderError(['message' => 'Message not found, please return back', 'code' => 404]);
        }
        return $message;
    }

    /**
     * Count number of pages for pagination
     * @param int $limit
     * @param mixed $id
     * @return int
     */
    public function countPages(int $limit, ?int $id = null): int
    {
        $recordCount = $this->model->getCount($id)["COUNT(id)"];
        return ceil($recordCount / $limit);
    }
}
