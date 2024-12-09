<?php

namespace app\models;

use app\models\Model;

class Message extends Model
{
    public function __construct()
    {
        parent::__construct('messages');
    }

    /**
     * Get limited number of messages records starting from offset
     * @param int $id
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getMessagesByTopic(int $id, int $offset, int $limit): ?array
    {
        $offset *= $limit;
        $query = "SELECT * FROM {$this->table} WHERE topic_id = ? ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        return $this->fetchAll($query, 'i', [$id]);
    }

    /**
     * Get count of messages records with specified topic
     * @param int $id
     * @return array
     */
    public function getCount(int $id): array
    {
        $query = "SELECT COUNT(id) FROM {$this->table} WHERE topic_id = ?";
        return $this->fetchOne($query, 'i', [$id]);
    }
}
