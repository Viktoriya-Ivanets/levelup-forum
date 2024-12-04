<?php

use app\core\Router;

/**
 * Here you can define new routes
 */
Router::add('login', ['controller' => 'Auth', 'action' => 'login']);
Router::add('logout', ['controller' => 'Auth', 'action' => 'logout']);
Router::add('register', ['controller' => 'Auth', 'action' => 'register']);
Router::add('', ['controller' => 'Category', 'action' => 'index']);
