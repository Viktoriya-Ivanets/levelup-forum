<?php

namespace app\models;

use app\models\Model;

class Category extends Model
{
    public function __construct()
    {
        parent::__construct('categories');
    }

    /**
     * Get count of categories records
     * @param mixed $id
     * @return array
     */
    public function getCount(?int $id): array
    {
        return $this->fetchOne("SELECT COUNT(id) FROM {$this->table}");
    }

    /**
     * Get limited number of categories records starting from offset
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getLimitedCount(int $offset, int $limit): array
    {
        $offset *= $limit;
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}");
    }
}
