<?php
require_once 'app/services/AuthService.php';
require_once 'app/helpers/LoginChecker.php';
require_once 'app/helpers/FileSaver.php';

class AdminController
{
  protected $renderer;
  protected $authService;
  protected $adminModel;


  public function __construct()
  {
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
    $this->authService = new AuthService();
  }

  // PROTECTED
  public function getUsers()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $this->adminModel->index();
  }
  public function banUser($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $this->adminModel->ban($vars["id"]);
  }

  /**
  public function registerAdmin()
    {
      $this->authService->registerAdmin($_POST);
    }
   */


  // PUBLIC
  
  public function loginAdmin()
  {
    $this->authService->loginAdmin($_POST);
  }

  public function logoutAdmin()
  {
    $this->authService->logoutAdmin();
  }
}
