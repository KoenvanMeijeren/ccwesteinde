<?php

namespace App\services\core;

use App\model\admin\account\User;
use App\services\exceptions\CustomException;

class Router
{
    /**
     * All the routes, stored based on the request type -> rights -> url.
     * Rights:
     * 1 = Student
     * 2 = Teacher
     * 3 = read
     * 4 = read and write
     * 5 = read, write and update
     * 6 = read, write, update and destroy
     * 7 = account management
     *
     * @var array
     */
    private static $_routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * All the available routes based on the current rights of the user.
     *
     * @var array
     */
    private static $_availableRoutes = [];

    /**
     * The current used wildcard.
     *
     * @var int
     */
    private static $_wildcard;

    /**
     * Load the routes
     *
     * @param string $file The file location of the routes.
     *
     * @return Router
     */
    public static function load(string $file)
    {
        loadFile(ROUTES_PATH . "/" . $file);

        return new static();
    }

    /**
     * Define the get routes.
     *
     * @param string $route      The get route.
     * @param string $controller The controller to execute when the route is called.
     * @param int    $rights     The minimum rights of the user to be able to visit the route.
     *
     * @return void
     */
    public static function get(string $route, string $controller, int $rights = 0)
    {
        self::$_routes['GET'][$rights][$route] = $controller;
    }

    /**
     * Define the post routes.
     *
     * @param string $route      The post route.
     * @param string $controller The controller to execute when the route is called.
     * @param int    $rights     The minimum rights of the user to be able to visit the route.
     *
     * @return void
     */
    public static function post(string $route, string $controller, int $rights = 0)
    {
        self::$_routes['POST'][$rights][$route] = $controller;
    }

    /**
     * Return the current used wildcard.
     *
     * @return int|string
     */
    public static function getWildcard()
    {
        return self::$_wildcard;
    }

    /**
     * Direct an url to a controller.
     *
     * @param string $url         The current url to search for the corresponding route in the routes.
     * @param string $requestType The request type.
     *
     * @return bool
     * @throws CustomException
     */
    public function direct(string $url, string $requestType)
    {
        $this->_setAvailableRoutes($requestType, new User());
        $this->_replaceWildcards($url);
        if (array_key_exists($url, self::$_availableRoutes)) {
            return $this->_executeRoute($url);
        }

        $this->_setAvailableRoutes('GET', new User());
        if (array_key_exists('fourNullFour', self::$_availableRoutes)) {
            return $this->_executeRoute('fourNullFour');
        }

        throw new CustomException('No route defined for this url');
    }

    /**
     * Execute the route and call the controller.
     *
     * @param string $url The current url to search for the corresponding route in the routes.
     *
     * @return bool
     */
    private function _executeRoute(string $url)
    {
        $route = explode('@', self::$_availableRoutes[$url]);
        $controller = 'App\controllers\\' . $route[0] ?? '';
        $controller = new $controller();
        $methodName = $route[1] ?? 'index';

        Validate::var($controller)->isObject();
        Validate::var($controller)->methodExists($methodName);

        return $controller->$methodName();
    }

    /**
     * Set the available routes based on the current rights of the user.
     *
     * @param string $requestType The request type.
     * @param User   $user        The current user of the app.
     *
     * @return void
     */
    private function _setAvailableRoutes(string $requestType, User $user)
    {
        $rights = $user->getRights();
        for ($i = 0; $i <= $rights; $i++) {
            if (isset(self::$_routes[$requestType][$i])) {
                self::$_availableRoutes = array_merge(self::$_availableRoutes, self::$_routes[$requestType][$i]);
            }
        }
    }

    /**
     * Replace the wildcards in the given routes.
     * Store the current used wildcard.
     *
     * @param string $url The current url.
     *
     * @return void
     */
    private function _replaceWildcards(string $url)
    {
        foreach (array_keys(self::$_availableRoutes) as $route) {
            $routeExploded = explode('/', $route);
            $urlExploded = explode('/', $url);
            if (preg_match('/\{[a-zA-Z]+\}/', $route)) {
                $this->_updateRoute($routeExploded, $urlExploded, $route);
            }
        }
    }

    /**
     * Update a specific route. Replace the slug for the matching value from the url.
     *
     * @param array  $routeExploded The route exploded in parts divided by slashes.
     * @param array  $urlExploded   The url exploded in parts divided by slashes.
     * @param string $route         The route to search for a replacement.
     *
     * @return void
     */
    private function _updateRoute(array $routeExploded, array $urlExploded, string $route)
    {
        // if route and url exploded are not the same size, return.
        if (count($urlExploded) !== count($routeExploded)) {
            return;
        }

        // loop through the route exploded array and if there is a match
        // if it contains {a-zA-Z} replace it with the same value on the same position from the url exploded array
        foreach ($routeExploded as $key => $routePart) {
            if (isset($urlExploded[$key]) && preg_match('/\{[a-zA-Z]+\}/', $routePart)) {
                $newRoute = preg_replace('/\{[a-zA-Z]+\}/', $urlExploded[$key], $route);
                self::$_wildcard = $urlExploded[$key];
                self::$_availableRoutes = array_replace_keys(self::$_availableRoutes, [$route => $newRoute]);

                return;
            }
        }
    }
}
