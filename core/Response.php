<?php

namespace App\Core;

class Response {
  
  /**
   * setStatusCode
   *
   * @param int $code
   * @return void
   */
  public function setStatusCode (?int $code): void {
    http_response_code($code);
  }
}