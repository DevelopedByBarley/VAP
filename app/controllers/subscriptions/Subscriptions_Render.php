<?php
require_once 'app/controllers/subscriptions/Subscriptions_Controller.php';

class SubscriptionsRender extends SubscriptionsController
{
  public function __construct()
  {
    parent::__construct();
  }

   // RENDER REGISTER TO EVENT FORM FOR USERS
   public function subscribeForm($vars)
   {
     session_start();
     $id = $vars["id"];
 
 
     $event = $this->eventModel->getEventById($id);
     $user = $this->userModel->getMe();
 
     if (!$event) {
       header("Location: /");
       exit;
     }
     $dates = $this->eventModel->getEventDates($id);
     $links = $this->eventModel->getEventLinks($id);
     $tasks = $this->eventModel->getEventTasks($id);
     $user = $this->userModel->getMe();
     $lang = $_COOKIE["lang"] ?? null;
     $prev = $_SESSION["prevSubContent"] ?? null;
 
 
     echo $this->renderer->render("Layout.php", [
       "user" => $user,
       "content" => $this->renderer->render("/pages/user/events/Subscribe.php", [
         "user" => $user ?? null,
         "event" => $event ?? null,
         "dates" => $dates ?? null,
         "links" => $links ?? null,
         "tasks" => $tasks ?? null,
         "lang" => $lang,
         "prev" => $prev ?? null
       ]),
     ]);
   }
 

  // GET ALL SUBSCRIPTIONS FOR ADMIN
  public function subscriptions($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");


    $eventId = $vars["id"] ?? null;
    $admin = $this->adminModel->admin();
    $event = $this->eventModel->getEventById($eventId);

    $subscriptions = $this->subModel->getSubscriptionsByEvent($eventId);


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
  public function subscriber($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $subscriptionId = $vars["id"] ?? null;
    $user = $this->subModel->getSubbedUserById($subscriptionId);
    $eventId = $user["eventRefId"];

    $tasks = $this->eventModel->getEventTasks($eventId);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/Subscriber.php", [
        "admin" => $admin ?? null,
        "tasks" => $tasks ?? null,
        "user" => $user ?? null
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


  public function subMailForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $subId = $vars["id"];
    $sub = $this->subModel->getSubbedUserById($subId);

    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/events/MailToSub.php", [
        "admin" => $admin ?? null,
        "sub" => $sub ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
