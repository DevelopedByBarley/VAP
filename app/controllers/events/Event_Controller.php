<?php
require 'app/models/Event_Model.php';

class EventController extends AdminController
{
  protected $eventModel;
  protected $userModel;

  public function __construct()
  {
    parent::__construct();
    $this->eventModel = new eventModel();
    $this->userModel = new UserModel();
  }

  

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
    $this->eventModel->update($vars["id"], $_POST, $_FILES);
  }

  public function registerUserToEvent() {
    var_dump($_POST);
  }
}