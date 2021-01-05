<?php
require_once __DIR__.'/ContainerInterface.php';

class Container implements ContainerInterface {
    private static $instance;
    private $bindings = array();

    private function __construct()
    {}

    /**
     * @return Container
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function set($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    private function bound($abstract)
    {
        return isset($this->bindings[$abstract]);
    }

    public function make($abstract)
    {
        if (!$this->bound($abstract)) {
            throw new NotFoundException("Could not resolve $abstract from bindings.");
        }

        return $this->bindings[$abstract];
    }

    public function get($id)
    {
        try {
            return $this->make($id);
        } catch (Exception $e) {
            if ($this->bound($id)) {
                throw $e;
            }

            throw new NotFoundException($id);
        }
    }

    public function has($id)
    {
        $this->bound($id);
    }
}