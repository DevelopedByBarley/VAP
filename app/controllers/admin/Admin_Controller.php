<?php
require 'app/services/AuthService.php';
require 'app/helpers/LoginChecker.php';
require 'app/helpers/FileSaver.php';

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
  public function getUsers()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $this->adminModel->index();
  }

  public function registerAdmin()
  {
    $this->authService->registerAdmin($_POST);
  }

  public function loginAdmin()
  {
    $this->authService->loginAdmin($_POST);
  }

  public function logoutAdmin()
  {
    $this->authService->logoutAdmin();
  }

}
