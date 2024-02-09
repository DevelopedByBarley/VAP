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
    $subscriptions = $this->subModel->getSubscriptionsByEvent($eventId);
    $countOfRegistrations = count($subscriptions);

    $anyAccepted = false;
    foreach ($subscriptions as $item) {
      if ((int)$item["isAccepted"] === 1) {
        $anyAccepted = true;
        break;
      }
    }

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Event.php", [
        "admin" => $admin ?? null,
        "event" => $event ?? null,
        "dates" => $dates ?? null,
        "tasks" => $tasks ?? null,
        "links" => $links ?? null,
        "subscriptions" => $subscriptions ?? null,
        "anyAccepted" => $anyAccepted ?? null,
        "countOfRegistrations" => $countOfRegistrations ?? null,
        "countOfUserByEmailStates" => $countOfUserByEmailStates ?? null,
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










  // RENDER EVENT FOR USER
  public function event($vars)
  {

    session_start();
    $eventId = $vars["id"] ?? null;
    $event = $this->eventModel->getEventById($eventId);
    $user = $this->userModel->getMe();
    $isRegistered = null;
    if ($user) {
      $isRegistered = $this->eventModel->checkIsUserRegisteredToEvent($eventId, $user["id"]);
    }


    if (!$event) {
      header("Location: /");
      exit;
    }

    $dates = $this->eventModel->getEventDates($eventId);
    $tasks = $this->eventModel->getEventTasks($eventId);
    $links = $this->eventModel->getEventLinks($eventId);

    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/events/Event.php", [
        "event" => $event ?? null,
        "dates" => $dates ?? null,
        "tasks" => $tasks ?? null,
        "links" => $links ?? null,
        "isRegistered" => $isRegistered

      ]),
    ]);
  }




  public function events()
  {

    $lang = $_COOKIE["lang"] ?? null;
    $user = $this->userModel->getMe();
    $events = $this->eventModel->index();


    echo $this->renderer->render("Layout.php", [
      "user" => $user,
      "content" => $this->renderer->render("/pages/user/events/Events.php", [
        "user" => $user ?? null,
        "events" => $events ?? null,
        "lang" => $lang,
      ]),
    ]);
  }
}
