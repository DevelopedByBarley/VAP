<?php


class AdminRender extends AdminController
{

  public function __construct()
  {
    parent::__construct();
  }


  // RENDER SINGLE REGISTERED USER DATA
  public function registeredUser($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $userId = $vars["id"] ?? null;

    $admin = $this->adminModel->admin();
    $user = $this->adminModel->user($userId);
    $tasks = $this->userModel->getTasksByUser($userId);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/User.php", [
        "admin" => $admin ?? null,
        "user" => $user ?? null,
        "tasks" => $tasks ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  // RENDER OF REGISTERED USERS
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


  // RENDER ADMIN LOGIN PAGE
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
