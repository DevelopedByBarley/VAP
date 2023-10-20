<?php

class EventRender extends EventController
{

  public function __construct()
  {
    parent::__construct();
  }


  /** PROTECTED */


  // GET ALL EVENTS FOR ADMIN
  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $eventsData = $this->eventModel->index($admin);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Events.php", [
        "admin" => $admin ?? null,
        "events" => $eventsData["events"] ?? null,
        "numOfPage" => (int)$eventsData["numOfPage"] ?? 1
      ]),
      "admin" => $admin ?? null
    ]);
  }


  // GET SINGLE EVENT BY ID FOR ADMIN
  public function adminEvent($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $eventId = $vars["id"] ?? null;
    $event = $this->eventModel->getEventById($eventId, $admin);
    $dates = $this->eventModel->getEventDates($eventId);
    $tasks = $this->eventModel->getEventTasks($eventId);
    $links = $this->eventModel->getEventLinks($eventId);
    $subscriptions = $this->eventModel->getRegistrationsByEvent($eventId);
    $countOfRegistrations = count($subscriptions);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Event.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
        "dates" => $dates ?? null,
        "tasks" => $tasks ?? null,
        "links" => $links ?? null,
        "subscriptions" => $subscriptions ?? null,
        "countOfRegistrations" => $countOfRegistrations ?? null,
        "countOfUserByEmailStates" => $countOfUserByEmailStates ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }

  // GET ALL SUBSCRIPTIONS FOR ADMIN
  public function subscriptions($vars)
  {;
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $eventId = $vars["id"] ?? null;
    $admin = $this->adminModel->admin();
    $event = $this->eventModel->getEventById($eventId);

    $subscriptions = $this->eventModel->getRegistrationsByEvent($eventId);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Subscriptions.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
        "subscriptions" => $subscriptions ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }

  // RENDER SINGLE SUBSCRIBER FOR ADMIN
  public function registeredUser($vars)
  {
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

  // RENDER EVENT REGISTRATION FORM FOR ADMIN
  public function eventForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $prev = $_SESSION["prevEventContent"] ?? null;

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Form.php", [
        "admin" => $admin ?? null,
        "prev" => $prev ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }




  // RENDER EVENT UPDATE FORM FOR ADMIN
  public function updateEventForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $event = $this->eventModel->getEventById($vars["id"], $admin);
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

  // RENDER MAIL FORM FOR ADMIN WITH CK EDITOR  FOR ADMIN
  public function mailForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $event = $this->eventModel->getEventById($vars["id"]);


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/MailForm.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }




  /** PUBLIC */

  // RENDER EVENTS FOR USERS
  public function events()
  {
    session_start();

    $events = $this->eventModel->index();

    $user = $this->userModel->getMe();

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/events/Events.php", [
        "user" => $user ?? null,
        "events" => $events ?? null
      ]),
    ]);
  }

  // RENDER EVENT FOR USER
  public function event($vars)
  {
    session_start();
    $eventId = $vars["id"] ?? null;
    $event = $this->eventModel->getEventById($eventId);

    if (!$event) {
      header("Location: /");
      exit;
    }

    $dates = $this->eventModel->getEventDates($eventId);
    $tasks = $this->eventModel->getEventTasks($eventId);
    $links = $this->eventModel->getEventLinks($eventId);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/user/events/Event.php", [
        "event" => $event ?? null,
        "dates" => $dates ?? null,
        "tasks" => $tasks ?? null,
        "links" => $links ?? null,
      ]),
    ]);
  }


  // RENDER REGISTER TO EVENT FORM FOR USERS
  public function registerToEventForm($vars)
  {
    session_start();
    $id = $vars["id"];


    $event = $this->eventModel->getEventById($id);

    if (!$event) {
      header("Location: /");
      exit;
    }
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
}
