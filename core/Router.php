<?php

namespace App\Core;

class Router {

  protected array $routes = [];
  public Request $request;
  public Response $response;
  
  /**
   * __construct
   * Prend en paramêtre une $request et une $response typé
   * On affecte aux propriétés request et response les valeurs passés en paramètre
   * @param \App\Core\Request $request
   * Paramètre Request $request 
   * @param \App\Core\Response $response
   * Paramètre Response $response 
   * 
   * 
   */
  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }
  
  /**
   * get
   *
   * @param string $path
   * @param mixed $callback
   * @return void
   */
  public function get (string $path, $callback): void {
    $this->routes['get'][$path] = $callback;
  }

  /**
   * post
   *
   * @param string $path
   * @param mixed $callback
   * @return void
   */
  public function post (string $path, $callback): void {
    $this->routes['post'][$path] = $callback;
  }

  /**
   * resolve
   * @param void
   * @return mixed
   */
  public function resolve () {
    $path = $this->request->getPath();
    $method = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;
    
    if (!$callback) {
      $this->response->setStatusCode(400);
      return $this->renderView('_404');
    } else {
      $this->response->setStatusCode(200);
    }

    if (is_string($callback)) return $this->renderView($callback);

    if (is_array($callback)) 
    Core::$app->controller = new $callback[0]();
    $callback[0] = Core::$app->controller;
    
    return call_user_func($callback, $this->request);
  }
  
  /**
   * renderView
   *
   * @param string $view
   * @return mixed
   */
  public function renderView (?string $view, array $params=[]) {
    $layoutContent = $this->layoutContent();
    $viewContent = $this->renderOnlyView(str_replace('.', '/', $view), $params);
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  /**
   * renderView
   *
   * @param string $view
   * @return mixed
   */
  public function renderContent (?string $viewContent) {
    $layoutContent = $this->layoutContent();
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }
  
  /**
   * layoutContent
   * @param void
   * @return mixed
   */
  protected function layoutContent () {
    $layout = Core::$app->controller->layout;

    ob_start();

    require_once Core::$rootPath . "/src/views/layout/{$layout}.php";

    return ob_get_clean();
  }
  
  /**
   * renderOnlyView
   *
   * @param string $view
   * @return string
   */
  protected function renderOnlyView (?string $view, array $params): ?string {

    foreach ($params as $key => $value) $$key = $value;

    ob_start();
    require_once Core::$rootPath . "/src/views/{$view}.php";
    
    return ob_get_clean();
  }
}