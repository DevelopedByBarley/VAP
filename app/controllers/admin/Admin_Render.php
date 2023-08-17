<?php


class AdminRender extends AdminController
{

  public function __construct()
  {
    parent::__construct();
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