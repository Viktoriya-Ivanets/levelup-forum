<?php

namespace app\utils;

class MessageValidation extends Validation
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

            if ($error = $this->checkLength($value)) {
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
    protected function checkLength(string $data): bool|string
    {
        if (strlen($data) > 65535) {
            return 'must be no longer than 65535 symbols';
        }
        return false;
    }
}
