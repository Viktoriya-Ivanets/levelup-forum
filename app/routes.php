<?php

use app\core\Router;

Router::add('login', ['controller' => 'Auth', 'action' => 'login']);
Router::add('register', ['controller' => 'Auth', 'action' => 'register']);
