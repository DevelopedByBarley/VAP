<?php
  require 'app/models/User_Model.php';
  require 'app/services/LanguageService.php';

  class UserController {
    private $userModel;
    private $languageService;

    public function __construct()
    {
      $this->userModel = new  UserModel();
      $this->languageService = new LanguageService();
    }


    public function setLanguage() {
      $this->languageService->language($_POST);
    }

    public function switchLanguage($vars) {
      $this->languageService->switch($vars["lang"]);
    }

  }
?>