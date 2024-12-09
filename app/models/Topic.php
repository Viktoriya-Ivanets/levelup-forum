<?php

namespace app\models;

use app\models\Model;

class Topic extends Model
{
    public function __construct()
    {
        parent::__construct('topics');
    }

    /**
     * Get limited number of topics records starting from offset
     * @param int $id
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getTopicsByCategory(int $id, int $offset, int $limit): ?array
    {
        $offset *= $limit;
        $query = "SELECT * FROM {$this->table} WHERE category_id = ? ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        return $this->fetchAll($query, 'i', [$id]);
    }

    /**
     * Get count of topics records with specified category
     * @param int $id
     * @return array
     */
    public function getCount(int $id): array
    {
        $query = "SELECT COUNT(id) FROM {$this->table} WHERE category_id = ?";
        return $this->fetchOne($query, 'i', [$id]);
    }
}
