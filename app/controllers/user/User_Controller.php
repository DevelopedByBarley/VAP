<?php
require 'app/models/User_Model.php';
require 'app/services/LanguageService.php';

class UserController
{
  protected $userModel;
  protected $languageService;
  protected $authService;
  protected $renderer;
  protected $loginChecker;
  protected $resetPwService;

  public function __construct()
  {
    $this->userModel = new  UserModel();
    $this->languageService = new LanguageService();
    $this->authService = new AuthService();
    $this->renderer = new Renderer();
    $this->loginChecker = new LoginChecker();
    $this->resetPwService = new ResetPw();
  }



  public function updateUser()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->update($_POST);
  }

  public function resetPassword()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->resetPw($_POST);
  }

  public function deleteUser() {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->delete($_POST);
    $this->authService->logoutUser();
  }
  
  public function deleteUserDocument($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->deleteDocument($vars["id"]);
  }


  
  public function updateUserDocument($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->updateDocument($vars["id"], $_FILES, $_POST);
  }
  
  public function newDocument() {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->addDocument($_FILES, $_POST);
  }


  public function setLanguage()
  {
    $this->languageService->language($_POST);
  }

  public function switchLanguage($vars)
  {
    $this->languageService->switch($vars["lang"]);
  }
  public function registration()
  {
    $this->userModel->registerUser($_FILES, $_POST);
  }
  

  public function login()
  {
    $this->authService->loginUser($_POST);
  }


  public function logout()
  {
    $this->authService->logoutUser();
  }

  public function newPwRequest() {
    $this->resetPwService->pwRequest($_POST);
  }

  public function setNewPw() {
    $this->resetPwService->newPw($_POST);
  }

}
