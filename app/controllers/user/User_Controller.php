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

  public function __construct()
  {
    $this->userModel = new  UserModel();
    $this->languageService = new LanguageService();
    $this->authService = new AuthService();
    $this->renderer = new Renderer();
    $this->loginChecker = new LoginChecker();
  }



  public function updateUser()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect('userId', '/login');
    $this->userModel->update($_POST);
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

  public function resetPassword()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect('userId', '/login');
    $this->userModel->resetPw($_POST);
  }

  public function deleteUser() {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->delete($_POST);
    $this->authService->logoutUser();
  }
  
  public function deleteUserDocument($vars) {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->deleteDocument($vars["id"]);
  }


  
  public function updateUserDocument($vars) {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->updateDocument($vars["id"], $_FILES, $_POST);
  }
  
  public function newDocument() {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->addDocument($_FILES, $_POST);
  }
}
