<?php
require_once 'app/models/Event_Model.php';
require_once 'app/models/User_Event_Model.php';

class EventController
{
  protected $eventModel;
  protected $userModel;
  protected $renderer;
  protected $adminModel;
  protected $userEventModel;

  public function __construct()
  {
    $this->eventModel = new eventModel();
    $this->userModel = new UserModel();
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
    $this->userEventModel = new UserEventModel;
  }


  /** PROTECTED */


  public function newEvent()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->eventModel->new($_FILES, $_POST);
  }

  public function deleteEvent($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->eventModel->delete($vars["id"]);
  }

  public function updateEvent($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $_SESSION["adminId"] ?? null;
    $this->eventModel->update($vars["id"], $_POST, $_FILES, $admin);
  }

  public function setEventState($vars)
  {

    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $state = $_GET["state"] ?? '';
    $this->eventModel->state($vars["id"], $state);
  }


  public function sendMailsToRegisteredUsers($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $subscriptions = $this->eventModel->getRegistrationsByEvent($vars["id"]);
    $this->eventModel->sendEmailToRegisteredUsers($_POST, $subscriptions);
  }

  public function deleteRegistration($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
    $this->userEventModel->delete($vars["id"]);
  }

  public function deleteRegistrationFromMail($vars)
  {
    $this->userEventModel->deleteRegistrationFromMailUrl($vars["id"]);
  }




  /** PUBLIC */


  public function registerUserToEvent($vars)
  {
    session_start();
    $user = $this->userModel->getMe();

    if ($user) {
      LoginChecker::checkUserIsLoggedInOrRedirect("userId", "/login");
      $user["documents"] = $this->userModel->getDocumentsByUser($user["id"]);
      $user["langs"] = $this->userModel->getLanguagesByUser($user["id"]);
    }

    $this->userEventModel->register($vars["id"], $_POST, $_FILES, $user);
  }
}
