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

  public function registrations()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $admin = $this->adminModel->admin();
    $usersData = $this->adminModel->index();



    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/registrations/Registrations.php", [
        "admin" => $admin ?? null,
        "users" => $usersData["users"] ?? null,
        "numOfPage" => $usersData["numOfPage"] ?? null,
        "limit" => $usersData["limit"] ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function loginAdmin()
  {
    $this->authService->loginAdmin($_POST);
  }

  public function logoutAdmin()
  {
    $this->authService->logoutAdmin();
  }


  public function adminLoginPage()
  {
    session_start();
    if (isset($_SESSION["adminId"])) {
      header("Location: /admin/registrations");
      return;
    }

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Login.php", [])
    ]);
  }
}
