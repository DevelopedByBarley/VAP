<?php
require 'app/models/Admin_Model.php';
require 'app/services/AuthService.php';
require 'app/helpers/LoginChecker.php';

class AdminController
{
  private $renderer;
  private $authService;

  public function __construct()
  {
    $this->renderer = new Renderer();
    $this->authService = new AuthService();
  }

  public function registerAdmin()
  {
    $this->authService->register($_POST);
  }

  public function loginAdmin()
  {
    $this->authService->login($_POST);
  }

  public function logoutAdmin()
  {
    $this->authService->logout();
  }

  public function adminDashboard()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/administrator");
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Dashboard.php", [])
    ]);
  }

  public function adminLoginPage()
  {
    session_start();
    if (isset($_SESSION["adminId"])) {
      header("Location: /administrator/dashboard");
      return;
    }
    
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Login.php", [])
    ]);
  }
}
