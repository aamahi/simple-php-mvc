<?php
require_once __DIR__.'/HttpMethods.php';

class Router {
    private $routes = [];

    public function validate($url, $method, $callable)
    {
        if (empty($url)) {
            throw new Exception("A path/url is required to add a route");
        }

        if (empty($method) || !in_array($method, [
                HttpMethods::GET, HttpMethods::POST, HttpMethods::PUT, HttpMethods::DELETE
            ])) {
            throw new Exception('Invalid request method');
        }

        if (!isset($callable['callback']) && !isset($callable['controller'])) {
            throw new Exception("Either a callback or a controller is required");
        }
    }


    /**
     * @param $url
     * @param $method
     * @param array $callable
     * @throws Exception
     */
    public function add($url, $method, $callable = array())
    {
        $this->validate($url, $method, $callable);

        if (!isset($this->routes[$method])) {
            $this->routes[$method] = array();
        }

        $this->routes[$method][$url] = $callable;
    }

    /**
     * @param $method
     * @param $url
     * @throws Exception
     */
    public function match($method, $url)
    {
        if (!isset($this->routes[$method])) {
            throw new \Exception("Invalid route method");
        }

        if (!isset($this->routes[$method][$url])) {
            throw new \Exception("Invalid route url");
        }

        return $this->routes[$method][$url];
    }
}