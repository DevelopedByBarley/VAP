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

  public function eventForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Form.php", [
        "admin" => $admin ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }


  public function userEventForm($vars) {
    $id = $vars["id"];
    $event = $this->eventModel->getEventById($id);
    $dates = $this->eventModel->getEventDates($id);
    $links = $this->eventModel->getEventLinks($id);
    $tasks = $this->eventModel->getEventTasks($id);

    $lang = $_COOKIE["lang"] ?? null;


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/events/Form.php", [
        "event" => $event ?? null,
        "dates" => $dates ?? null,
        "links" => $links ?? null,
        "tasks" => $tasks ?? null,
        "lang" => $lang,
        
      ]),
    ]);
  }


  public function updateEventForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $event = $this->eventModel->getEventById($vars["id"]);
    $event_dates = $this->eventModel->getEventDates($vars["id"]);
    $event_links = $this->eventModel->getEventLinks($vars["id"]);
    $event_tasks = $this->eventModel->getEventTasks($vars["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/UpdateForm.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
        "event_dates" => $event_dates ?? null,
        "event_links" => $event_links ?? null,
        "event_tasks" => $event_tasks ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
