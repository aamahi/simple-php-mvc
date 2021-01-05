<?php

class Request {
    private $path;
    private $data;
    private $method;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    private function getRequestData() {
        $input = file_get_contents("php://input");
        return [
            HttpMethods::GET => $_GET,
            HttpMethods::POST => $_POST,
            HttpMethods::PUT => $input,
            HttpMethods::DELETE => $input,
        ];
    }

    public function capture() {
        $url = $_SERVER['REQUEST_URI'];
        list($path) = explode("?", $url);
        $this->path = rtrim($path, '/');
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = $this->getRequestData()[$this->method];
        return $this;
    }
}