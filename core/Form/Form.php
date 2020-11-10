<?php

namespace App\Core\Form;

use App\Core\Model;

class Form {
  
  /**
   * beginTag
   *
   * @param string $action
   * @param string $method
   * @return mixed
   */
  public static function beginTag (string $action, string $method) {
    echo sprintf('<form action="%s" onsubmit="" class="form" method="%s">', $action, $method);
    return new Form();
  }
  
  /**
   * endTag
   *
   * @return void
   */
  public static function endTag (): void {
    echo '</form>';
  }
  
  /**
   * field
   *
   * @param Model $model
   * @param string $attribute
   * @return mixed
   */
  public function field (Model $model, string $attribute) {
    return new Field($model, $attribute);
  }
  
  /**
   * fieldTypes
   *
   * @return array
   */
  public function fieldTypes () : array {
    return [
      'username' => '',
      'email' => 'email',
      'password' => 'password',
      'passwordConfirm' => 'password'
    ];
  }
}