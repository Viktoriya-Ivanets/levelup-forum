<?php

namespace app\utils;

class TopicValidation extends Validation
{
    /**
     * Validate the fields for category
     * @param array $data
     * @return array
     */
    public function validateFields(array $data): array
    {
        $errors = [];

        foreach ($data as $field => $value) {
            $fieldErrors = [];

            if ($error = $this->notEmpty($value)) {
                $fieldErrors[] = ucfirst($field) . ' ' . $error;
            }

            if ($error = $this->checkLength($value, $length = $field === 'description' ? 65535 : 255)) {
                $fieldErrors[] = ucfirst($field) . ' ' . $error;
            }

            if (!empty($fieldErrors)) {
                $errors[$field] = implode(', ', $fieldErrors);
            }
        }

        return $errors;
    }

    /**
     * Checks if the passed string is not empty and generates an error
     * @param string $data
     * @return bool|string
     */
    protected function notEmpty(string $data): bool|string
    {
        if ($data === '') {
            return 'cannot be empty';
        }
        return false;
    }

    /**
     * Check length of the passed string end generates an error
     * @param string $data
     * @param int $length
     * @return bool|string
     */
    protected function checkLength(string $data, int $length): bool|string
    {
        if (strlen($data) > $length) {
            return 'must be no longer than ' . $length . ' symbols';
        }
        return false;
    }
}
