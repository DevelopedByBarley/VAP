<?php
require 'app/models/Event_Model.php';

class EventController extends AdminController
{
  private $eventModel;

  public function __construct()
  {
    parent::__construct();
    $this->eventModel = new eventModel();
  }

  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $events = $this->eventModel->getEvents();
    
    
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Events.php", [
        "admin" => $admin ?? null,
        "events" => $events ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
  
  
  public function newEvent() {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->eventModel->new($_FILES, $_POST);
  }
  
  public function deleteEvent($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->eventModel->delete($vars["id"]);
  }

  public function eventForm() {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Form.php", [
        "admin" => $admin ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }

}
