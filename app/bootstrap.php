<?php
require_once('../vendor/autoload.php');
require_once 'constants.php';

/**
 * Loads configuration settings from a .conf file.
 *
 * Reads each line from the .conf file, skips comments, and sets environment variables.
 *
 * @throws Exception If the .conf file does not exist or cannot be accessed.
 */
function loadConfig(): void
{
    $configFile = '..' . DIRECTORY_SEPARATOR . '.conf';
    if (!file_exists($configFile)) {
        throw new Exception('File .conf does not exist');
    }
    $handle = fopen($configFile, 'r');
    if (!$handle) {
        throw new Exception('Cannot access the .conf file');
    }
    while (!feof($handle)) {
        $row = trim(fgets($handle));
        if (!empty($row) && strpos($row, '#') !== 0) {
            putenv($row);
        }
    }
}

/**
 * Retrieves the value of a configuration setting.
 *
 * Fetches the value of an environment variable set by the loadConfig function.
 *
 * @param string $key The configuration key to retrieve.
 * @return string|false The value of the configuration key, or false if it is not set.
 */
function conf(string $key): array|bool|string
{
    return getenv($key);
}

loadConfig();

require_once 'routes.php';

$router = new app\core\Router();
$router->dispatch($_SERVER['REQUEST_URI']);
