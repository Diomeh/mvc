<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public static Application $APP;

    public Controller $controller;
    public Response $response;
    public Request $request;
    public Router $router;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$APP = $this;

        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request, $this->response);
    }

    public function run() { echo $this->router->resolve(); }

};
