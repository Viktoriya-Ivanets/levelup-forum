<?php

namespace app\utils;

use DateTime;

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

    public static function getDate(string $date): string
    {
        $result = new DateTime($date);
        return $result->format('d M, Y');
    }

    public static function getTime(string $date): string
    {
        $result = new DateTime($date);
        return $result->format('H:i');
    }
}
