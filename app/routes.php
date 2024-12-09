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
Router::add('categories/(\d+)/topics', ['controller' => 'Topic', 'action' => 'index']);
Router::add('categories/(\d+)/topics/create', ['controller' => 'Topic', 'action' => 'create']);
Router::add('categories/(\d+)/topics/store', ['controller' => 'Topic', 'action' => 'store']);
Router::add('categories/(\d+)/topics/edit/(\d+)', ['controller' => 'Topic', 'action' => 'edit']);
Router::add('categories/(\d+)/topics/update', ['controller' => 'Topic', 'action' => 'update']);
Router::add('categories/(\d+)/topics/delete/(\d+)', ['controller' => 'Topic', 'action' => 'delete']);
Router::add('categories/(\d+)/topics/(\d+)/messages', ['controller' => 'Message', 'action' => 'index']);
Router::add('categories/(\d+)/topics/(\d+)/messages/create', ['controller' => 'Message', 'action' => 'create']);
Router::add('categories/(\d+)/topics/(\d+)/messages/store', ['controller' => 'Message', 'action' => 'store']);
Router::add('categories/(\d+)/topics/(\d+)/messages/edit/(\d+)', ['controller' => 'Message', 'action' => 'edit']);
Router::add('categories/(\d+)/topics/(\d+)/messages/update', ['controller' => 'Message', 'action' => 'update']);
Router::add('categories/(\d+)/topics/(\d+)/messages/delete/(\d+)', ['controller' => 'Message', 'action' => 'delete']);
