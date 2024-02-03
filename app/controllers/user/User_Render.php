<?php
require_once 'app/helpers/ResetPw.php';

class UserRender extends UserController
{

  public function __construct()
  {
    parent::__construct();
  }

  // RENDER LOGIN FORM FOR USERS
  public function loginForm()
  {
    session_start();
    if (isset($_SESSION["userId"])) {
      header("Location: /user/dashboard");
      return;
    }

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Login.php", []),
    ]);
  }

  // RENDER REGISTER FORMS FOR USERS
  public function registerForm()
  {
    session_start();
    $user = $this->userModel->getMe();

    if ($user) {
      header('Location: /');
      exit;
    }
    $prev = $_SESSION["prevRegContent"] ?? null;
    $errors = $_SESSION["regErrors"] ?? null;


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Register.php", [
        "prev" => $prev ?? null,
        "errors" => $errors ?? null
      ])
    ]);

  }

  // RENDER DASHBOARD FOR USERS
  public function dashboard()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);
    $userLanguages = $this->userModel->getLanguagesByUser($user["id"]);
    $subscriptions = $this->userModel->getRegistrationsByUser($user["id"]);
    $event = $this->eventModel->getLatestEvent();


    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/Dashboard.php", [
        "user" => $user ?? null,
        "event" => $event,
        "documents" => $documents ?? null,
        "userLanguages" => $userLanguages ?? null,
        "subscriptions" => $subscriptions ?? null,
      ]),
    ]);
  }


  // RENDER RESET PASSWORD FORM FROM USER SETTINGS
  public function resetPasswordForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/ResetPassword.php", [
        "user" => $user ?? null,
      ]),
    ]);
  }

  // RENDER USER DOCUMENTS PAGE FROM USER SETTINGS
  public function userDocuments()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/Documents.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
      ]),
    ]);
  }

  // RENDER UPDATE USER DOCUMENTS PAGE FROM USER SETTINGS
  public function updateUserDocumentForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $document = $this->userModel->getDocumentById($vars["id"]);


    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/UpdateDocumentForm.php", [
        "user" => $user ?? null,
        "document" => $document ?? null,
      ]),
    ]);
  }

  // RENDER USER DOCUMENTS FORM FROM USER SETTINGS
  public function documentForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $document = $this->userModel->getDocumentsByUser($user["id"]);


    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/DocumentForm.php", [
        "user" => $user ?? null,
        "document" => $document ?? null,
      ]),
    ]);
  }


  // RENDER FORGOT PW FORM FOR USERS
  public function forgotPwForm()
  {
    session_start();
    $errors = $_SESSION["forgotPwFormErrors"] ?? null;

  
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Forgot_Pw_Form.php", [
        "errors" => $errors
      ]),
    ]);
  }

  // RENDER FORGOT PW FORM FOR USERS
  public function resetPwForm()
  {
    session_start();

    $user = $_SESSION["userId"] ?? null;

    if($user) {
      $this->authService->logoutUser();
    }

    $token = $_GET["token"] ?? null;
    $expires = $_GET["expires"] ?? null;
    $emailByToken = $this->resetPwService->checkTokenData($token, $expires);

    if (!$emailByToken) {
      $this->alert->set("Token lejárt vagy nem létezik", "Token is expired or doesn't exist!", null, "danger", "/login");
    }


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Reset_Pw_Form.php", [
        "emailByToken" => $emailByToken,
        "token" => $token
      ]),

    ]);
  }

  // RENDER PROFILE SETTINGS FORM FOR USERS
  public function profileSettingsForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);
    $userLanguages = $this->userModel->getLanguagesByUser($user["id"]);
    $tasks = $this->userModel->getTasksByUser($user["id"]);

    $errors = $_SESSION["profileUpdateError"] ?? null;

    echo $this->renderer->render("Layout.php", [
      "user" => $user ?? null,
      "content" => $this->renderer->render("/pages/user/Profile_Settings.php", [
        "user" => $user ?? null,
        "tasks" => $tasks ?? null,
        "documents" => $documents ?? null,
        "userLanguages" => $userLanguages ?? null,
        "errors" => $errors ?? null
      ]),
    ]);
  }
}
