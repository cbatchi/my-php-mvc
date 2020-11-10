<?php

namespace App\Core;

class Core {

  public static string $rootPath;
  public static Core $app;

  public Router $router;
  public Request $request;
  public Response $response;
  public Database $db;
  public Controller $controller;
  
  /**
   * __construct
   *
   * @param string $rootPath
   * @return mixed
   */
  public function __construct(?string $rootPath)
  {
    self::$rootPath = $rootPath;
    self::$app = $this;
    require_once self::$rootPath . '/config/helper.php';

    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
    $this->db = new Database(dbConf()->db);    
  }
    
  /**
   * run
   * @param void 
   * @return void
   */
  public function run (): void {
    echo $this->router->resolve();
  }

  /**
   * Get the value of controller
   * @return \App\Core\Controller
   */ 
  public function getController(): Controller
  {
    return $this->controller;
  }

  /**
   * Set the value of controller
   * @param \App\Core\Controller $controller
   * @return void
   */ 
  public function setController(Controller $controller): void
  {
    $this->controller = $controller;
  }
}