<?php

namespace app\models;

use app\core\View;
use app\models\Model;

class Message extends Model
{
    public function __construct()
    {
        parent::__construct('messages');
    }

    /**
     * Fetch all messages with specified topic
     * @param int $id
     * @return array
     */
    public function getMessagesByTopic(int $id): ?array
    {
        $query = "SELECT * FROM messages WHERE topic_id = ?";
        $result = $this->fetchAll($query, 'i', [$id]);
        return $result;
    }
}
