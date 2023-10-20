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

  // GET ALL OF USERS  
  public function getUsers()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $this->adminModel->index();
  }

  // BAN USER /// MEG KELL CSINÁLNI MINDEN USER ADAT TÖRLÉSÉT!
  public function banUser($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    
    $this->adminModel->ban($vars["id"]);
  }
  
    // LOGOUT ADMIN
    public function logoutAdmin()
    {
      LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
      $this->authService->logoutAdmin();
    }
  
  // PUBLIC
  
  // LOGIN ADMIN
  
  public function loginAdmin()
  {
    $this->authService->loginAdmin($_POST);
  }

}
