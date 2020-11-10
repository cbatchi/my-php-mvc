<?php

namespace App\Model;

use App\Core\Model;

/**
 * Class UserModel
 * @author BATCHI <claude.batchi@epitech.eu>
 * 
 */
class UserModel extends Model
{
  
  public string $username = '';
  public string $email = '';
  public string $password = '';
  public string $passwordConfirm = '';

  public function registerAction()
  {
    
  }

  public function loginAction($data)
  {
  }

  public function rules(): array
  {
    return [
      'username' => [self::RULE_REQUIRED],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
      'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
    ];
  }
}