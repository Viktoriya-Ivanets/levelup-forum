<?php

use app\core\Router;

/**
 * Here you can define new routes
 */
Router::add('login', ['controller' => 'Auth', 'action' => 'login']);
Router::add('logout', ['controller' => 'Auth', 'action' => 'logout']);
Router::add('register', ['controller' => 'Auth', 'action' => 'register']);
Router::add('categories', ['controller' => 'Category', 'action' => 'index']);
Router::add('categories/create', ['controller' => 'Category', 'action' => 'create']);
Router::add('categories/store', ['controller' => 'Category', 'action' => 'store']);
Router::add('categories/edit/(\d+)', ['controller' => 'Category', 'action' => 'edit']);
Router::add('categories/update', ['controller' => 'Category', 'action' => 'update']);
Router::add('categories/delete/(\d+)', ['controller' => 'Category', 'action' => 'delete']);
