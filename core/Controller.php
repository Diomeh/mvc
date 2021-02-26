<?php

namespace app\core;

class Controller
{
    public string $layout = 'main';
    public function render($view, $params = [], $layout = 'main')
    {
        return Application::$APP->router->renderView($view, $params);
    }

    public function setLayout($layout) { $this->$layout = $layout; }
}