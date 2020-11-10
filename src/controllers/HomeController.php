<?php

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller {

  public function homepage () {

    $this->setLayout('main');
    return $this->render('index', [
      'name' => 'claude'
    ]);
  }
} 