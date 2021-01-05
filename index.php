<?php
require_once './framework/router/RouteDispatcher.php';

try {
    $dispatcher = new RouteDispatcher();
    $dispatcher->dispatch();
} catch (Exception $exception) {
    echo $exception->getMessage();
}