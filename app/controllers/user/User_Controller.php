<?php
require_once 'app/models/User_Model.php';
require_once 'app/models/Event_Model.php';
require_once 'app/models/Subscription_Model.php';
require_once 'app/helpers/Alert.php';

class UserController
{
  protected $userModel;
  protected $languageService;
  protected $authService;
  protected $renderer;
  protected $loginChecker;
  protected $resetPwService;
  protected $eventModel;
  protected $alert;
  protected $subModel;

  public function __construct()
  {
    $this->userModel = new  UserModel();
    $this->languageService = new LanguageService();
    $this->authService = new AuthService();
    $this->renderer = new Renderer();
    $this->loginChecker = new LoginChecker();
    $this->resetPwService = new ResetPw();
    $this->eventModel = new EventModel();
    $this->subModel = new Subscription_Model();
    $this->alert = new Alert();
  
  }


  // PROTECTED

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

  public function deleteUser()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->delete($_POST);
    $this->authService->logoutUser();
  }

  public function deleteUserDocument($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->deleteDocument($vars["id"]);
  }



  public function updateUserDocument($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->updateDocument($vars["id"], $_FILES, $_POST);
  }

  public function newDocument()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->addDocument($_FILES, $_POST);
  }

  
  public function logout()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->authService->logoutUser();
  }



  public function registration()
  {
    session_start();
    $this->userModel->registerUser($_FILES, $_POST);
  }
  

  public function login()
  {
    $this->authService->loginUser($_POST);
  }



  public function newPwRequest()
  {
    $this->resetPwService->pwRequest($_POST);
  }

  public function setNewPw()
  {
    $this->resetPwService->newPw($_POST);
  }

  public function activateRegisterFromEmail() {
    $this->userModel->activateRegister();
  }

}
