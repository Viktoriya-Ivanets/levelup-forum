<?php

namespace app\utils;

class Helpers
{
    /**
     * Filters and returns array of data
     * @param array $fields
     * @return array
     */
    public static function getPostData(array $fields): array
    {
        $postData = [];

        foreach ($fields as $field) {
            $value = filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $value !== null && $value !== false ? $postData[$field] = $value : $postData[$field] = null;
        }

        return $postData;
    }

    /**TODO Move to View and render error template
     * Renders an error message and stops execution
     * @param string $message
     * @return never
     */
    public static function renderError(string $message): never
    {
        echo $message;
        exit();
    }
}
