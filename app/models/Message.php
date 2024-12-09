<?php

namespace app\models;

use app\models\Model;
use app\utils\Helpers;

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

    /**
     * Finds a message by ID or throws an error
     * @param int $id
     * @return array
     */
    public function findMessageOrFail(int $id): array
    {
        $message = $this->getById($id);
        if (!$message) {
            Helpers::renderError('Message not found');
        }
        return $message;
    }
}
