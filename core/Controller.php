<?php

namespace app\core;

class Controller
{
    public string $layout = 'main';
    public function render($view, $params = [])
    {
        return Application::$APP->router->renderView($view, $params);
    }
}