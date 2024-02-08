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

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/Login.php", [])
    ]);
  }
}
