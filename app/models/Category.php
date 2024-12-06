<?php

namespace app\models;

use app\models\Model;
use app\utils\Helpers;

class Category extends Model
{
    public function __construct()
    {
        parent::__construct('categories');
    }

    /**
     * Finds a category by ID or throws an error
     * @param int $id
     * @return array
     */
    public function findCategoryOrFail(int $id): array
    {
        $category = $this->getById($id);
        if (!$category) {
            Helpers::renderError('Category not found');
        }
        return $category;
    }
}
