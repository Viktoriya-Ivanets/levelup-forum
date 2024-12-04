<?php

namespace app\utils;

use mysqli;
use mysqli_result;

class Database
{
    private static ?mysqli $connection = null;

    /**
     * Establishes and returns a singleton database connection.
     * 
     * @return mysqli The active database connection.
     * @throws Exception If the connection fails.
     */
    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            self::$connection = new mysqli(conf('DB_HOST'), conf('DB_USER'), conf('DB_PASS'), conf('DB_NAME'));

            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }

            self::$connection->set_charset("utf8mb4");
        }

        return self::$connection;
    }

    /**
     * Executes a query with optional parameter binding.
     * 
     * @param string $query The SQL query to execute.
     * @param string $types A string containing types for binding parameters.
     * @param array $params An array of parameters to bind to the query.
     * 
     * @return mysqli_result|bool The result of the query execution (if SELECT query) or a boolean indicating success.
     */
    public static function executeQuery(string $query, string $types = '', array $params = []): mysqli_result|bool
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare($query);

        if ($types && count($params) > 0) {
            $stmt->bind_param($types, ...$params);
        }

        $isSuccess = $stmt->execute();

        if (str_starts_with(strtolower(trim($query)), 'select')) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }

        $stmt->close();
        return $isSuccess;
    }

    /**
     * Closes the active database connection, if it exists.
     * 
     * @return void
     */
    public static function closeConnection(): void
    {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}
