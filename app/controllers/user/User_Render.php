<?php
require_once 'app/helpers/ResetPw.php';

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
      ]),
    ]);
  }

  public function registerForm()
  {
    session_start();
    $user = $this->userModel->getMe();

    if($user) {
      header('Location: /');
      exit;
    }
    $prev = $_SESSION["prevRegisterContent"] ?? null;

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Register.php", [
        "prev" => $prev ?? null
      ])
    ]);
  }


  public function dashboard()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);
    $userLanguages = $this->userModel->getLanguagesByUser($user["id"]);
    $subscriptions = $this->userModel->getRegistrationsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/Dashboard.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
        "userLanguages" => $userLanguages ?? null,
        "subscriptions" => $subscriptions ?? null,
      ]),
    ]);
  }



  public function resetPasswordForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/ResetPassword.php", [
        "user" => $user ?? null,
      ]),
    ]);

  }

  public function userDocuments()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Documents.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
      ]),
    ]);
  }

  public function updateUserDocumentForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $document = $this->userModel->getDocumentById($vars["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/UpdateDocumentForm.php", [
        "user" => $user ?? null,
        "document" => $document ?? null,
      ]),
    ]);
  }

  public function documentForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $document = $this->userModel->getDocumentsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/DocumentForm.php", [
        "user" => $user ?? null,
        "document" => $document ?? null,
      ]),
    ]);
  }

  public function forgotPwForm()
  {
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Forgot_Pw_Form.php", []),
    ]);
  }


  public function resetPwForm()
  {
    $token = $_GET["token"] ?? null;
    $expires = $_GET["expires"] ?? null;
    $emailByToken = $this->resetPwService->checkTokenData($token, $expires);

    if (!$emailByToken) {
      echo "Token nem lejárt vagy nem létezik!";
      return;
    }


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Reset_Pw_Form.php", [
        "emailByToken" => $emailByToken,
        "token" => $token
      ]),

    ]);
  }

  public function profileSettingsForm() {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);
    $userLanguages = $this->userModel->getLanguagesByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "user" => $user ?? null,
      "content" => $this->renderer->render("/pages/user/Profile_Settings.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
        "userLanguages" => $userLanguages ?? null,
      ]),
    ]);
  }


}
