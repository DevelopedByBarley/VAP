
<?php
require_once 'app/services/AuthService.php';
require_once 'app/helpers/LoginChecker.php';
require_once 'app/helpers/FileSaver.php';
require_once 'app/models/User_Model.php';
require_once 'app/models/Subscription_Model.php';
require_once 'app/models/Event_Model.php';


class SubscriptionsController
{
  protected $renderer;
  protected $authService;
  protected $adminModel;
  protected $userModel;
  protected $subModel;
  protected $eventModel;


  public function __construct()
  {
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
    $this->authService = new AuthService();
    $this->userModel = new UserModel();
    $this->subModel = new Subscription_Model();
    $this->eventModel = new EventModel();
  }




  // EZ ADMIN SUBSCRIPTION CONTROLLER
  public function acceptSubscription($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $subId = $vars["id"];

    $this->subModel->acceptUserSubscription($subId);
  }



  public function declineSubscription($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $subId = $vars["id"];
    $this->subModel->declineUserSubscription($subId);
  }



  public function sendMailsToSubbeddUsers($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $subscriptions = $this->subModel->getSubscriptionsByEvent($vars["id"]);
    $this->subModel->sendEmailToSubbedUsers($_POST, $subscriptions, $vars["id"]);
  }


  public function sendMailToSub($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $this->subModel->sendMailToSub($_POST, $vars["id"]);
  }


  public function deleteSubscription($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $user = (int)$_SESSION['userId'] ?? null;
    $this->subModel->deleteSubscription($user, (int)$vars["id"]);
  }

  /** PUBLIC */

  public function deleteSubscriptionFromMail($vars)
  {
    $this->subModel->deleteSubscriptionFromMailUrl($vars["id"]);
  }



  public function exportSubs()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");

    $XLSX = new XLSX();
    $data = $XLSX->getAcceptedSubs($_GET["id"]);


    $XLSX->write($data);
    exit;
  }


  public function subscribeUserToEvent($vars)
  {
    session_start();
    $user = $this->userModel->getMe();

    if ($user) {
      LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
      $user["documents"] = $this->userModel->getDocumentsByUser($user["id"]);
      $user["langs"] = $this->userModel->getLanguagesByUser($user["id"]);
    }

    $this->subModel->subscribe($vars["id"], $_POST, $_FILES, $user);
  }
}
?>