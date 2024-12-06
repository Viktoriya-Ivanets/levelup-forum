<?php

namespace app\models;

use app\models\Model;
use app\utils\Helpers;

class Topic extends Model
{
    public function __construct()
    {
        parent::__construct('topics');
    }

    /**
     * Fetch all topics with specified category
     * @param int $id
     * @return array
     */
    public function getTopicsByCategory(int $id): ?array
    {
        $query = "SELECT * FROM topics WHERE category_id = ?";
        $result = $this->fetchAll($query, 'i', [$id]);
        return $result;
    }

    /**
     * Finds a topic by ID or throws an error
     * @param int $id
     * @return array
     */
    public function findTopicOrFail(int $id): array
    {
        $topic = $this->getById($id);
        if (!$topic) {
            Helpers::renderError('Topic not found');
        }
        return $topic;
    }
}
