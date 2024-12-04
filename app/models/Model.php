<?php

namespace app\models;

use app\utils\Database;

class Model
{
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Fetches all rows from a SELECT query.
     * 
     * @param string $query The SQL query to execute.
     * @param string $types A string containing types for binding parameters.
     * @param array $params An array of parameters to bind to the query.
     * 
     * @return array An array of associative arrays representing the rows.
     */
    protected function fetchAll(string $query, string $types = '', array $params = []): array
    {
        $result = Database::executeQuery($query, $types, $params);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Fetches a single row from a SELECT query.
     * 
     * @param string $query The SQL query to execute.
     * @param string $types A string containing types for binding parameters.
     * @param array $params An array of parameters to bind to the query.
     * 
     * @return array|null The associative array representing the row, or null if no row is found.
     */
    protected function fetchOne(string $query, string $types = '', array $params = []): ?array
    {
        $result = Database::executeQuery($query, $types, $params);
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Retrieves a record by its ID.
     * 
     * @param int $id The ID of the record.
     * 
     * @return array|null The associative array representing the record, or null if not found.
     */
    public function getById(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM {$this->table} WHERE id = ?", 'i', [$id]);
    }

    /**
     * Retrieves all records from the table.
     * 
     * @return array An array of associative arrays representing the records.
     */
    public function getAll(): array
    {
        return $this->fetchAll("SELECT * FROM {$this->table}");
    }

    /**
     * Creates a new record in the table.
     * 
     * @param array $data An associative array of column names and values to insert.
     * 
     * @return bool True if the record was successfully created, false otherwise.
     */
    public function create(array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $types = str_repeat('s', count($data));
        $values = array_values($data);

        return Database::executeQuery("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)", $types, $values);
    }

    /**
     * Updates an existing record by its ID.
     * 
     * @param int $id The ID of the record to update.
     * @param array $data An associative array of column names and values to update.
     * 
     * @return bool True if the record was successfully updated, false otherwise.
     */
    public function update(int $id, array $data): bool
    {
        $updates = implode(',', array_map(fn($col) => "$col = ?", array_keys($data)));
        $types = str_repeat('s', count($data)) . 'i';
        $values = array_merge(array_values($data), [$id]);

        return Database::executeQuery("UPDATE {$this->table} SET $updates WHERE id = ?", $types, $values);
    }

    /**
     * Deletes a record by its ID.
     * 
     * @param int $id The ID of the record to delete.
     * 
     * @return bool True if the record was successfully deleted, false otherwise.
     */
    public function delete(int $id): bool
    {
        return Database::executeQuery("DELETE FROM {$this->table} WHERE id = ?", 'i', [$id]);
    }
}
