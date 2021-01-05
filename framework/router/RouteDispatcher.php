<?php
require_once './framework/Application.php';
require_once './routes/routes.php';

class RouteDispatcher {
    private $app;
    private $request;
    private $router;

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->request = $this->app->make('request');
        $this->router = $this->app->make('router');
    }

    /**
     * @throws Exception
     */
    public function dispatch()
    {
        $url = $this->request->getPath();
        $method = $this->request->getMethod();
        $data = $this->request->getData();

        $callable = $this->router->match($method, $url);

        if (isset($callable['callback'])) {
            $callback = $callable['callback'];
            return $callback($data);
        }

        if (isset($callable['controller'])) {
            $controllerDefinition = $callable['controller'];
            list($controller, $method) = explode('@', $controllerDefinition);
            require_once __DIR__."/../../controllers/$controller.php";
            $controllerInstance = new $controller;
            return $controllerInstance->$method($data);
        }

        throw new Exception('Either callback or controller is required');
    }
}