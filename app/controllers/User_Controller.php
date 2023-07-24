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
    $this->userModel->registerUser($_FILES, $_POST);
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
  
  public function deleteUserDocument($vars) {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->deleteDocument($vars["id"]);
  }


  
  public function updateUserDocument($vars) {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->updateDocument($vars["id"], $_FILES, $_POST);
  }
  
  public function newDocument() {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userModel->addDocument($_FILES, $_POST);
  }














  public function dashboard()
  {
    $this->loginChecker->checkUserIsLoggedInOrRedirect("userId", "/login");
    $user =  $this->userModel->getMe();
    $documents = $this->userModel->getDocumentsByUser($user["id"]);
    
    
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/Dashboard.php", [
        "user" => $user ?? null,
        "documents" => $documents ?? null,
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

  public function userDocuments() {
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

  public function updateUserDocumentForm($vars) {
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

  public function documentForm() {
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
