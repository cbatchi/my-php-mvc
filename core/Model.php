<?php

namespace App\Core;

/**
 * Abstract class Model
 * @author BATCHI <claude.batchi@epitech.eu>
 */
abstract class Model {

  public const RULE_REQUIRED = 'required'; 
  public const RULE_EMAIL = 'email'; 
  public const RULE_MIN = 'min'; 
  public const RULE_MAX = 'max'; 
  public const RULE_MATCH = 'match'; 
  public array $errors = [];
  
    
  /**
   * loadData
   *
   * @param array $data
   * @return void
   */
  public function loadData (array $data): void {
    foreach($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }
   
  /**
   * rules
   *
   * @return array
   */
  abstract public function rules(): array;

  
  /**
   * validate
   *
   * @return bool
   */
  public function validate (): bool {
    foreach ($this->rules() as $attribute => $rules) {
      $value = $this->{$attribute};

      
      foreach ($rules as $rule) {
        
        $rulesName = $rule;
        
        if (!is_string($rulesName)) {
          $rulesName = $rule[0];
        }
        
        if ($rulesName === self::RULE_REQUIRED && !$value && !preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
          $this->addError($attribute, self::RULE_REQUIRED);
        }
        
        if ($rulesName === self::RULE_EMAIL && !preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $value)) {
          $this->addError($attribute, self::RULE_EMAIL);
        }
        
        if ($rulesName === self::RULE_MIN && strlen($value) < $rule['min']) {
          $this->addError($attribute, self::RULE_MIN, $rule);
        }
        
        if ($rulesName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
          $this->addError($attribute, self::RULE_MATCH, $rule);
        }
        
      }
    }
    return empty($this->errors);
  }
  

  /**
   * addError
   *
   * @param string $attribute
   * @param string $rule
   * @return void
   */
  public function addError (string $attribute, string $rule, array $params=[]) {
    $message = $this->errorMessage()[$rule] ?? '';
    foreach ($params as $key => $value) {
      $message = str_replace("{{$key}}", $value, $message);
    }
    $this->errors[$attribute][] = $message;
  }
  
  /**
   * errorMessage
   *
   * @return array
   */
  public function errorMessage (): array {
    return [
      self::RULE_REQUIRED => 'This field is required',
      self::RULE_EMAIL => 'This field must be valid email adress',
      self::RULE_MIN => 'Min length of this field must be {min}',
      self::RULE_MATCH => 'This field must be the same as {match}',
    ];
  }
  
  /**
   * hasError
   *
   * @param string $attribute
   * 
   */
  public function hasError (string $attribute): bool {
    return !empty($this->errors[$attribute]) ?? false;
  }
  
  /**
   * getFirstError
   *
   * @param string $attribute
   * @return string
   */
  public function getFirstError (string $attribute): string {
    return $this->errors[$attribute][0] ?? false;
  }

}