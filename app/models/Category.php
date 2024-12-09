<?php

namespace app\models;

use app\core\View;
use app\models\Model;

class Category extends Model
{
    public function __construct()
    {
        parent::__construct('categories');
    }
}
