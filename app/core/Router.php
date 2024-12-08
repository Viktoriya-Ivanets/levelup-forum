<?php

namespace app\core;

class Router
{
    protected static $routes = [];
    protected $params = [];

    /**
     * Adds a route to the routing table
     *
     * @param string $route The URL pattern for the route
     * @param array $params Parameters associated with the route, such as controller and action
     */
    public static function add(string $route, array $params = []): void
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
    private function match($url): bool
    {
        foreach (self::$routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;

                if (preg_match_all('(\d+)', $url, $numberMatches)) {
                    $this->params['ids'] = array_map('intval', $numberMatches[0]);
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
    public function dispatch($url): void
    {
        Session::start();
        $publicRoutes = ['login', 'register'];

        $url = trim($url, '/');
        if (!Session::get('token') && !in_array($url, $publicRoutes)) {
            self::redirect('login');
            return;
        }

        if ($this->match($url)) {
            $controllerClass = '\\app\\controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            if (class_exists($controllerClass)) {
                $controllerObject = new $controllerClass();

                $actionMethod = $this->params['action'];
                if (method_exists($controllerObject, $actionMethod)) {
                    $controllerObject->$actionMethod($this->params);
                } else {
                    http_response_code(404);
                    echo "Error: Method '$actionMethod' not found in controller '$controllerClass'.";
                }
            } else {
                http_response_code(404);
                echo "Error: Controller '$controllerClass' not found.";
            }
        } else {
            http_response_code(404);
            echo "Error: Page not found!";
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
