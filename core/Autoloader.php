<?php

namespace App\Core;

class Autoloader {
  
  /**
   * register
   * @param void
   * @return void
   */
  public static function register (): void {
    spl_autoload_register([__CLASS__, 'load']);
  }
  
  /**
   * load
   *
   * @param mixed $class
   * @return void
   */
  public static function load ($class) {
    $class = explode("\\", $class);
    $class = end($class) . '.php';
    $paths = [
      'cores' => [
        'core' =>  dirname(__DIR__) . '/core/',
        'form' => dirname(__DIR__) . '/core/Form/',
        'src' => [
          'controller' => implode(DIRECTORY_SEPARATOR, ['../src', 'controllers/']),
          'model' => implode(DIRECTORY_SEPARATOR, ['../src', 'models/'])
        ]
      ]
    ];

    foreach($paths as $value)
    {
      if (is_array($value)) {
        foreach($value as $content) {
          if(is_array($content)) {
            foreach($content as $subVal) {
              file_exists($subVal . $class) ? require_once $subVal . $class : '';
            }
          } else {
            file_exists($content . $class) ? require_once $content . $class : '';
          }
        }
      }
    }
  }
}