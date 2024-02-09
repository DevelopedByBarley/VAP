<?php
require_once 'app/models/Event_Model.php';
require_once 'app/models/Subscription_Model.php';
require_once 'app/helpers/ExportExcel.php';


class EventController
{
  protected $eventModel;
  protected $userModel;
  protected $renderer;
  protected $adminModel;
  protected $subModel;


  public function __construct()
  {
    $this->eventModel = new eventModel();
    $this->userModel = new UserModel();
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
    $this->subModel = new Subscription_Model();
  }


  /** PROTECTED */


  // ADD NEW EVENT
  public function newEvent()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->eventModel->new($_FILES, $_POST);
  }

  // DELETE EVENT
  public function deleteEvent($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->eventModel->delete($vars["id"]);
  }

  // UPDATE EVENT
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

}
