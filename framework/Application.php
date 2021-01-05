<?php
require_once __DIR__.'/container/Container.php';
require_once __DIR__.'/router/Router.php';
require_once __DIR__.'/view-engine/ViewEngine.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/storage/Model.php';

class Application {
    /**
     * @var Container $container
     */
    private static $container = null;
    private function __construct()
    {
    }

    private static function init()
    {
        $container = Container::getInstance();
        $container->set('view engine', new ViewEngine());
        $container->set('router', new Router());
        $container->set('request', (new Request())->capture());
        $container->set('storage', new Model());
        static::$container = $container;
    }

    public static function getInstance() {
        if (!static::$container) {
            static::init();
        }
        return static::$container;
    }
}