<?php


class AdminRender extends AdminController
{

  public function __construct()
  {
    parent::__construct();
  }
  // RENDER ADMIN LOGIN PAGE
  public function adminLoginPage()
  {
    session_start();
    if (isset($_SESSION["adminId"])) {
      header("Location: /admin/registrations");
      return;
    }

    $this->userModel->deleteExpiredRegistrations();
    $this->userModel->deleteExpiresPasswordResetTokens();

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Login.php", [])
    ]);
  }




  // RENDER OF REGISTERED PROFILES

  public function registrations()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION
    $usersData = $this->adminModel->index(); // GET ALL REGISTERED PROFILES

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

  // RENDER SINGLE REGISTERED USER DATA
  public function profile($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $userId = $vars["id"] ?? null;

    $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION
    $user = $this->adminModel->user($userId); // GET USER BY USER ID
    $tasks = $this->userModel->getTasksByUser($userId); // GET TASKS BY USERS ID


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/registrations/User.php", [
        "admin" => $admin ?? null,
        "user" => $user ?? null,
        "tasks" => $tasks ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  public function userMailPage($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin(); // GET ADMIN BY SESSION
    $user = $this->adminModel->user($vars["id"]);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/registrations/MailToUser.php", [
        "admin" => $admin ?? null,
        "user" => $user ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
