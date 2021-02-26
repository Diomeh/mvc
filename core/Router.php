<?php

namespace app\core;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get ($path, $callback) { $this->routes['get' ][$path] = $callback; }

    public function post($path, $callback) { $this->routes['post'][$path] = $callback; }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }

        // Render string
        if (is_string($callback))
            return $this->renderView($callback);

        // Instantiate controller if is array
        if(is_array($callback)) 
            Application::$APP->controller = $callback[0] = new $callback[0]();

        // Execute callback
        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        return $this->renderContent($viewContent);
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$APP->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        // This functions does the same thing the loop does.
        // From the docs: import variables into the current symbol table from an array 
        extract($params, EXTR_OVERWRITE);

        // Variable variables approach
        // foreach ($params as $key => $value)
        //     $$key = $value;

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
