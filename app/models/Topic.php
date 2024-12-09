<?php

namespace app\models;

use app\core\View;
use app\models\Model;

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
}
