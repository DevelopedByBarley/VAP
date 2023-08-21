<?php


class UserRender extends UserController
{


  public function __construct()
  {
    parent::__construct();
  }




  public function loginForm()
  {
    session_start();
    if (isset($_SESSION["userId"])) {
      header("Location: /user/dashboard");
      return;
    }

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Login.php", [
        "alertContent" => $this->renderer->render("/components/Alert.php", [])
      ]),
    ]);

    if (isset($_SESSION["alert"])) unset($_SESSION["alert"]);
  }

  public function registerForm()
  {
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Register.php", [])
    ]);
  }


  public function dashboard()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);
    $userLanguages = $this->userModel->getLanguagesByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Dashboard.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
        "userLanguages" => $userLanguages ?? null,
        "alertContent" => $this->renderer->render("/components/Alert.php", [])
      ]),
    ]);
    if (isset($_SESSION["alert"])) unset($_SESSION["alert"]);
  }



  public function resetPasswordForm()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/ResetPassword.php", [
        "user" => $user ?? null,
        "alertContent" => $this->renderer->render("/components/Alert.php", [])
      ]),
    ]);

    if (isset($_SESSION["alert"])) unset($_SESSION["alert"]);
  }

  public function userDocuments()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Documents.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
        "alertContent" => $this->renderer->render("/components/Alert.php", [])
      ]),
    ]);
  }

  public function updateUserDocumentForm($vars)
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $document = $this->userModel->getDocumentById($vars["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/UpdateDocumentForm.php", [
        "user" => $user ?? null,
        "document" => $document ?? null,
        "alertContent" => $this->renderer->render("/components/Alert.php", [])
      ]),
    ]);
  }

  public function documentForm()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $document = $this->userModel->getDocumentsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/DocumentForm.php", [
        "user" => $user ?? null,
        "document" => $document ?? null,
        "alertContent" => $this->renderer->render("/components/Alert.php", [])
      ]),
    ]);
  }
}
