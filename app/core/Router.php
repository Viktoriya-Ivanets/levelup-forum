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

                if (preg_match('#/page/(\d+)$#', $url, $pageMatch)) {
                    $this->params['page'] = (int)$pageMatch[1];
                } else {
                    $this->params['page'] = 1;
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
        $url = trim($url, '/');

        if (!$this->isAuthorized($url)) {
            self::redirect('login');
            return;
        }

        if ($this->match($url)) {
            $this->handleMatchedRoute();
        } else {
            $this->handleNotFound();
        }
    }

    /**
     * Checks if the user is authorized to access the given URL.
     *
     * @param string $url The URL being accessed.
     * @return bool True if authorized, false otherwise.
     */
    private function isAuthorized(string $url): bool
    {
        $publicRoutes = ['login', 'register'];
        return Session::get('token') || in_array($url, $publicRoutes);
    }

    /**
     * Handles the logic when a route is successfully matched.
     */
    private function handleMatchedRoute(): void
    {
        $controllerClass = '\\app\\controllers\\' . ucfirst($this->params['controller']) . 'Controller';

        if (!class_exists($controllerClass)) {
            error_log("Error: Controller '$controllerClass' not found.");
            $this->renderError(404, 'Page not found');
            return;
        }

        $controllerObject = new $controllerClass();
        $actionMethod = $this->params['action'];

        if (!method_exists($controllerObject, $actionMethod)) {
            error_log("Error: Method '$actionMethod' not found in controller '$controllerClass'.");
            $this->renderError(404, 'Page not found');
            return;
        }

        $controllerObject->$actionMethod($this->params);
    }

    /**
     * Handles the logic when a route is not matched.
     */
    private function handleNotFound(): void
    {
        error_log("Error: Page not found!");
        $this->renderError(404, 'Page not found');
    }

    /**
     * Renders an error page.
     *
     * @param int $code HTTP status code.
     * @param string $message Error message to display.
     */
    private function renderError(int $code, string $message): void
    {
        (new View())->renderError(['message' => $message, 'code' => $code]);
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
