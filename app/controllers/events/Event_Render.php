<?php

class EventRender extends EventController
{

  public function __construct()
  {
    parent::__construct();
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

  public function event($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $eventId = $vars["id"] ?? null;
    $event = $this->eventModel->getEventById($eventId);
    $subscriptions = $this->eventModel->getRegistrationsByEvent($eventId);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Event.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
        "subscriptions" => $subscriptions ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }


  public function registeredUser($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $eventId = $vars["id"] ?? null;
    $event = $this->eventModel->getEventById($eventId);
    $user = $this->eventModel->getRegisteredUser($vars["id"]);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/User.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
        "user" => $user ?? null
      ]),
      "admin" => $admin ?? null
    ]);
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


  public function registerToEventForm($vars)
  {
    session_start();
    $id = $vars["id"];

    $event = $this->eventModel->getEventById($id);
    $dates = $this->eventModel->getEventDates($id);
    $links = $this->eventModel->getEventLinks($id);
    $tasks = $this->eventModel->getEventTasks($id);
    $user = $this->userModel->getMe();
    $lang = $_COOKIE["lang"] ?? null;

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/events/Register.php", [
        "user" => $user ?? null,
        "event" => $event ?? null,
        "dates" => $dates ?? null,
        "links" => $links ?? null,
        "tasks" => $tasks ?? null,
        "lang" => $lang,
      ]),
    ]);
  }


  public function success() {
    session_start();
    $lang = $_COOKIE["lang"] ?? null;

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/events/Success.php", [
        "lang" => $lang,
      ]),
    ]);
  }
}
