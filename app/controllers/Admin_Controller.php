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




  public function adminDashboard()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Dashboard.php", [
        "admin" => $admin ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function adminLoginPage()
  {
    session_start();
    if (isset($_SESSION["adminId"])) {
      header("Location: /admin/dashboard");
      return;
    }

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Login.php", [])
    ]);
  }
}
