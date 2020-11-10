<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Model\UserModel;

/**
 * Class AuthController
 * @author BATCHI <claude.batchi@epitech.eu>
 */
class AuthController extends Controller {
  
  /**
   * 
   * @param Request $request
   * @return mixed
   * Méthode register
   * 
   * Permet de de faire une action  d'enregistrement de nouvel utilisateur
   */
  public function register (Request $request) {
    $userModel = new UserModel();

    if ($request->isPost()) {
      $userModel->loadData($request->getBody());
      
      if ($userModel->validate() && $userModel->registerAction()) {
        return 'success';
      }
      
      return $this->render('auth.register', [
        'model' => $userModel
      ]);
    }

    return $this->render('auth.register', [
      'model' => $userModel
    ]);

    // Ajout du modele d'heritage
    $this->setLayout('auth');
    
  }
  
  /**
   * login
   *
   * @param Request $request
   * @return mixed
   */
  public function login (Request $request) {
    if ($request->isPost()) return 'Data submited';

    return $this->render('auth.login');
    $this->setLayout('auth');
  }
  
  
  /**
   * contactUs
   *
   * @param Request $request
   * @return mixed
   */
  public function contactUs (Request $request) {
    if ($request->isPost()) return 'Message send';

    $this->setLayout('main');
    return $this->render('pages.contact');
  }

}