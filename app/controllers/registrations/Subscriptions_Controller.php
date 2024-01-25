
<?php
require_once 'app/services/AuthService.php';
require_once 'app/helpers/LoginChecker.php';
require_once 'app/helpers/FileSaver.php';
require_once 'app/models/User_Model.php';


class SubscriptionsController
{
  protected $renderer;
  protected $authService;
  protected $adminModel;
  protected $userModel;


  public function __construct()
  {
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
    $this->authService = new AuthService();
    $this->userModel = new UserModel();
  }

  // BAN USER /// MEG KELL CSINÁLNI MINDEN USER ADAT TÖRLÉSÉT!
  public function banUser($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $this->adminModel->ban($vars["id"]);
  }


  public function sendMailToUser($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->adminModel->sendMailToUser($_POST, $vars["id"]);
  }
 
}
?>