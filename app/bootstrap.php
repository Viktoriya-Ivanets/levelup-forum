<?php
require_once('../vendor/autoload.php');
require_once 'constants.php';

function loadConfig()
{
    $configFile = '..' . DIRECTORY_SEPARATOR . '.conf';
    if (!file_exists($configFile)) {
        throw new Exception('File .conf does not exists');
    }
    $handle = fopen($configFile, 'r');
    if (!$handle) {
        throw new Exception('Cannot access to .conf file');
    }
    while (!feof($handle)) {
        $row = trim(fgets($handle));
        if (!empty($row) && strpos($row, '#') !== 0) {
            putenv($row);
        }
    }
}

function conf(string $key)
{
    return getenv($key);
}

loadConfig();

require_once 'routes.php';

$router = new app\core\Router();
$router->dispatch($_SERVER['REQUEST_URI']);
