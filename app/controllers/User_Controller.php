<?php
require 'app/models/User_Model.php';
require 'app/services/LanguageService.php';

class UserController
{
  private $userModel;
  private $languageService;
  private $renderer;

  public function __construct()
  {
    $this->userModel = new  UserModel();
    $this->languageService = new LanguageService();
    $this->renderer = new Renderer();
  }

  public function registerUser() {
    $this->userModel->register($_POST);
  }


  public function setLanguage()
  {
    $this->languageService->language($_POST);
  }

  public function switchLanguage($vars)
  {
    $this->languageService->switch($vars["lang"]);
  }

  public function registerForm()
  {
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/Register.php", [])
    ]);
  }
}
