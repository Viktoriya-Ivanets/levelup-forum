<?php

namespace app\utils;

use app\core\View;

abstract class Validation
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Validates input data and renders errors if any
     * @param array $fields
     * @param string $view
     * @return array|null
     */
    public function getValidatedData(array $fields, string $view): ?array
    {
        $postData = Helpers::getPostData($fields);

        if ($errors = $this->validateFields($postData)) {
            $this->view->render($view, ['errors' => $errors, 'old' => $postData]);
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
