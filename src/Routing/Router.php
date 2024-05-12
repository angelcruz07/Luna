<?php

namespace Lune\Routing;

use Closure;
use Lune\Http\HttpMethod;
use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;


/**
 * HTTP Router.
 */
class Router {
    /**
     * HTTP routes.
     * 
     * @var array<string, Route[]>
     */
    protected array $routes = [];

    /**
     * Constructs a new Router instance.
     */
    public function __construct() {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    /**
     * Resolves the request and returns the matching route.
     * 
     * @param Request $request The HTTP request to resolve.
     * @return Route The matching route.
     * @throws HttpNotFoundException If no matching route is found.
     */
    public function resolve(Request $request) {
        foreach ($this->routes[$request->method()->value] as $route) {
            if ($route->matches($request->uri())) {
                return $route;
            }
        }

        throw new HttpNotFoundException();
    }

    /**
     * Registers a new route for the GET HTTP method.
     * 
     * @param string $uri The URI pattern to match.
     * @param Closure $action The action to be executed when the route is matched.
     */
    public function get(string $uri, \Closure $action) {
        $this->registerRoute(HttpMethod::GET, $uri, $action);
    }

    /**
     * Registers a new route for the POST HTTP method.
     * 
     * @param string $uri The URI pattern to match.
     * @param Closure $action The action to be executed when the route is matched.
     */
    public function post(string $uri, Closure $action) {
        $this->registerRoute(HttpMethod::POST, $uri, $action);
    }

    /**
     * Registers a new route for the PUT HTTP method.
     * 
     * @param string $uri The URI pattern to match.
     * @param Closure $action The action to be executed when the route is matched.
     */
    public function put(string $uri, Closure $action) {
        $this->registerRoute(HttpMethod::PUT, $uri, $action);
    }

    /**
     * Registers a new route for the PATCH HTTP method.
     * 
     * @param string $uri The URI pattern to match.
     * @param Closure $action The action to be executed when the route is matched.
     */
    public function patch(string $uri, Closure $action) {
        $this->registerRoute(HttpMethod::PATCH, $uri, $action);
    }

    /**
     * Registers a new route for the DELETE HTTP method.
     * 
     * @param string $uri The URI pattern to match.
     * @param Closure $action The action to be executed when the route is matched.
     */
    public function delete(string $uri, Closure $action) {
        $this->registerRoute(HttpMethod::DELETE, $uri, $action);
    }

    /**
     * Registers a new route for the specified HTTP method.
     * 
     * @param HttpMethod $method The HTTP method.
     * @param string $uri The URI pattern to match.
     * @param Closure $action The action to be executed when the route is matched.
     */
    protected function registerRoute(HttpMethod $method, string $uri, Closure $action) {
        $this->routes[$method->value][] = new Route($uri, $action);
    }
}

?>