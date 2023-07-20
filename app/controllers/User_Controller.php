<?php
require 'app/models/User_Model.php';
require 'app/services/LanguageService.php';

class UserController
{
  private $userModel;
  private $languageService;
  private $authService;
  private $renderer;
  private $loginChecker;

  public function __construct()
  {
    $this->userModel = new  UserModel();
    $this->languageService = new LanguageService();
    $this->authService = new AuthService();
    $this->renderer = new Renderer();
    $this->loginChecker = new LoginChecker();
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


  public function updateUser()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect('userId', '/login');
    $this->userModel->update($_POST);
  }


  public function setLanguage()
  {
    $this->languageService->language($_POST);
  }

  public function switchLanguage($vars)
  {
    $this->languageService->switch($vars["lang"]);
  }
  public function registration()
  {
    $this->authService->registerUser($_FILES, $_POST);
  }
  
  public function registerForm()
  {
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Register.php", [])
    ]);
  }


  public function login()
  {
    $this->authService->loginUser($_POST);
  }


  public function logout()
  {
    $this->authService->logoutUser();
  }

  public function resetPassword()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect('userId', '/login');
    $this->userModel->resetPw($_POST);
  }

  public function deleteUser() {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->delete($_POST);
    $this->authService->logoutUser();

  }

  public function dashboard()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Dashboard.php", [
        "user" => $user ?? null,
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
}
