<?php

namespace app\utils;

use app\core\Session;
use app\core\View;

abstract class Validation
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Validates input data and stores errors to the session
     * @param array $fields
     * @return array|null
     */
    public function getValidatedData(array $fields): ?array
    {
        $postData = Helpers::getPostData($fields);

        if ($errors = $this->validateFields($postData)) {
            Session::set('errors', $errors);
            Session::set('old', $postData);
            $postData = null;
        }

        return $postData;
    }

    /**
     * Abstract method to be implemented by child classes
     * @param array $data
     * @return array
     */
    abstract public function validateFields(array $data): array;
}
