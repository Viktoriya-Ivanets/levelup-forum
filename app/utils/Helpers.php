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

    /**
     * Convert date from y-m-d h:i:s to d M, Y
     * @param string $date
     * @return string
     */
    public static function getDate(string $date): string
    {
        $result = new DateTime($date);
        return $result->format('d M, Y');
    }

    /**
     * Convert date from y-m-d h:i:s to H:i
     * @param string $date
     * @return string
     */
    public static function getTime(string $date): string
    {
        $result = new DateTime($date);
        return $result->format('H:i');
    }
}
