<?php

namespace App\Core;

class Controller {

  public string $layout = 'main';
    
  /**
   * setLayout
   *
   * @param  mixed $layout
   * @return void
   */
  public function setLayout ($layout) {
    $this->layout = $layout;
  }

  /**
   * render
   *
   * @param  string $view
   * @param  array $params
   * @return mixed
   */
  public function render (?string $view, array $params=[]) {
    return Core::$app->router->renderView($view, $params);
  }
}