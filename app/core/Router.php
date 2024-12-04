<?php

namespace app\core;

class Router
{
    private static $routes = [];
    private $params = [];

    /**
     * Adds a route to the routing table
     *
     * @param string $route The URL pattern for the route
     * @param array $params Parameters associated with the route, such as controller and action
     */
    public static function add($route, $params = [])
    {
        $route = '#^' . $route . '$#';
        self::$routes[$route] = $params;
    }

    /**
     * Matches a URL to a route in the routing table
     *
     * @param string $url The URL to match against the routes
     * @return bool True if a match is found, false otherwise
     */
    private function match($url)
    {
        error_log(print_r(self::$routes, true));
        foreach (self::$routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                if (!empty($matches[1])) {
                    $this->params['id'] = $matches[1];
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Dispatches the request to the appropriate controller and action
     *
     * @param string $url The URL to dispatch
     */
    public function dispatch($url)
    {
        error_log($url);
        $url = trim($url, '/');

        if ($this->match($url)) {
            $controller = '\\app\\controllers\\' . $this->params['controller'] . 'Controller';
            error_log($controller);
            if (class_exists($controller)) {
                error_log("Found");
                $controllerObject = new $controller();
                $action = $this->params['action'];

                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action($this->params);
                } else {
                    echo "Method $action not found!";
                }
            } else {
                echo "Controller $controller not found!";
            }
        } else {
            http_response_code(404);
            echo "Page not found!";
        }
    }

    /**
     * Generates a URL for the specified route.
     *
     * @param string $route The route for which to generate the URL.
     * @return string The generated URL.
     */
    public static function url(string $route = ''): string
    {
        return '/' . $route;
    }

    /**
     * Redirects the user to the specified URL.
     *
     * @param string $url The URL to redirect to.
     * @return never
     */
    public static function redirect(string $url): never
    {
        $url = self::url($url);
        header('Location: ' . $url);
        exit();
    }
}
