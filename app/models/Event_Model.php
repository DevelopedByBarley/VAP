
<?php
require_once 'app/helpers/Alert.php';


class EventModel
{

  private $pdo;
  private $fileSaver;
  private $mailer;
  private $alert;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
    $this->alert = new Alert();
  }

  // SET EVENT PRIVATE WHEN IT IS EXPIRED
  public function setEventsPrivateIfExpired()
  {
    $today = date("Y-m-d");


    $stmt = $this->pdo->prepare("UPDATE events SET `isPublic` = '0' WHERE `isPublic` = '1' AND (`date` <= :today OR `reg_end_date` <= :today)");
    $stmt->bindParam(":today", $today);
    $stmt->execute();
  }

  private function setEventsPublic()
  {
    $today = date("Y-m-d");


    $stmt = $this->pdo->prepare("UPDATE events SET `isPublic` = '1' WHERE `isPublic` = '0' AND (`date` > :today OR `reg_end_date` > :today)");
    $stmt->bindParam(":today", $today);
    $stmt->execute();
  }

  // SET EVENT STATE BY $_GET PARAMETER / PUBLIC | PRIVATE
  public function state($id, $state)
  {
    $stmt = $this->pdo->prepare("UPDATE `events` SET `isPublic` = :state WHERE `events`.`eventId` = :id");
    $stmt->bindParam(":state", $state);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: /admin/event/$id");
  }



  // ADD NEW EVENT
  public function new($files, $body)
  {

    $fileName = $this->fileSaver->saver($files["image"], "/uploads/images/events", null, [
      'image/png',
      'image/jpeg',
    ]);
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_var($body["date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $end_date = filter_var($body["end_date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $reg_end_date = filter_var($body["reg_end_date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $links = $body["links"] ?? [];
    $event_dates = $body["event_dates"] ?? [];
    $isPublic = 1;
    $tasks = $body["task"] ?? [];
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `events` VALUES (NULL, :nameInHu, :nameInEn, :descriptionInHu, :descriptionInEn, :date, :end_date, :reg_end_date, :isPublic, :fileName, :createdAt)");
    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":end_date", $end_date);
    $stmt->bindParam(":reg_end_date", $reg_end_date);
    $stmt->bindParam(":isPublic", $isPublic);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();

    $lastId = $this->pdo->lastInsertId();
    if ($lastId) {
      self::insertLinksOfEvent($lastId, $links);
      self::insertDatesOfEvent($lastId, $event_dates);
      self::insertTasksOfEvent($lastId, $tasks);
    }


    self::sendMailForRegisteredUsers($lastId);

    $this->alert->set('Új esemény sikeresen hozzáadva!', null, null, "success", "/admin/events");
  }


  // DELETE EVENT

  public function delete($id)
  {
    $fileNameForDelete = self::getEventById($id)["fileName"];
    unlink("./public/assets/uploads/images/events/$fileNameForDelete");



    $stmt = $this->pdo->prepare("DELETE FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $this->alert->set('Esemény sikeresen törölve!', null, null, "success", "/admin/events");
  }



  // UPDATE EVENT

  public function update($id, $body, $files, $admin)
  {
    $event = self::getEventById($id, $admin);
    $prevImage = $event["fileName"];
    $createdAt = $event["createdAt"];


    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_var($body["date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $end_date = filter_var($body["end_date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $reg_end_date = filter_var($body["reg_end_date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $links = $body["links"] ?? [];
    $event_dates = $body["event_dates"] ?? [];

    $tasks = $body["task"] ?? [];

    $fileName = '';



    if ($files["image"]["name"] !== '') {
      unlink("./public/assets/uploads/images/events/$prevImage");
      $fileName = $this->fileSaver->saver($files["image"], "/uploads/images/events", null, [
        'image/png',
        'image/jpeg',
      ]);
    } else {
      $fileName = $prevImage;
    }



    $stmt = $this->pdo->prepare("UPDATE `events` SET 
    `nameInHu` = :nameInHu, 
    `nameInEn` = :nameInEn, 
    `descriptionInHu` = :descriptionInHu, 
    `descriptionInEn` = :descriptionInEn, 
    `date` = :date, 
    `end_date` = :end_date, 
    `reg_end_date` = :reg_end_date, 
    `fileName` = :fileName, 
    `createdAt` = :createdAt 
    WHERE `events`.`eventId` = :id");

    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":end_date", $end_date);
    $stmt->bindParam(":reg_end_date", $reg_end_date);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::updateEventLinks($id, $links);
    self::updateEventDates($id, $event_dates);
    self::updateEventTasks($id, $tasks);
    self::setEventsPublic();

    $this->alert->set('Új esemény sikeresen frissítve!', null, null, "success", "/admin/events");
  }





  // GET EVENTS ADMIN OR USER
  public function index($admin = null)
  {
    $offset = $_GET["offset"] ?? 1;
    $limit = 4; // Az oldalanként megjelenített rekordok száma
    $calculated = ($offset - 1) * $limit; // Az OFFSET értékének kiszámítása

    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `events`");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása


    $events = [];

    if ($admin) {
      $stmt = $this->pdo->prepare("SELECT * FROM events LIMIT $limit OFFSET $calculated");
      $stmt->execute();
      $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $stmt = $this->pdo->prepare("SELECT * FROM events WHERE `isPublic` = '1'");
      $stmt->execute();
      $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    foreach ($events as $index => $event) {
      $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `registrations` WHERE eventRefId = :id");
      $stmt->bindParam(":id", $event["eventId"]);
      $stmt->execute();
      $events[$index]["subscriptions"] = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    }

    return $admin ?  [
      "numOfPage" => $numOfPage,
      "events" => $events
    ] : $events;
  }


  // GET EVENT BY ID IF ADMIN | USER



  public function getEventById($id, $admin = null)
  {

    if (!$admin || !isset($admin)) {
      $stmt = $this->pdo->prepare("SELECT * FROM events WHERE eventId = :id AND `isPublic` = '1'");
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $event = $stmt->fetch(PDO::FETCH_ASSOC);

      return $event;
    }

    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    return $event;
  }



  // GET LATEST EVENT FOR CONTENT PAGE
  public function getLatestEvent()
  {
    $today = date("Y-m-d");

    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE (`isPublic` = '1') AND (`date` > :today OR `reg_end_date` > :today) ORDER BY `date` ASC LIMIT 1");
    $stmt->bindParam(":today", $today);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    return $event;
  }

  // REGISTRATIONS


  // GET ALL REGISTRATIONS BY EVENT

  public function getRegistrationsByEvent($eventId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE eventRefId = :id");
    $stmt->bindParam(":id", $eventId);
    $stmt->execute();
    $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $subscriptions;
  }

  // GET REGISTERED USER DATA BY ID
  public function getRegisteredUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $stmt = $this->pdo->prepare("SELECT * FROM registration_dates WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"]);
      $stmt->execute();
      $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["dates"] = $dates;

      $stmt = $this->pdo->prepare("SELECT * FROM registration_documents WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"]);
      $stmt->execute();
      $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["documents"] = $documents;

      $stmt = $this->pdo->prepare("SELECT * FROM registration_tasks WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"]);
      $stmt->execute();
      $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["tasks"] = $tasks;

      $stmt = $this->pdo->prepare("SELECT * FROM registration_languages WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"]);
      $stmt->execute();
      $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["langs"] = $tasks;
    }

    return $user;
  }





  public function checkIsUserRegisteredToEvent($eventId, $userId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` WHERE `userRefId` = :userId AND `eventRefId` = :eventId");
    $stmt->bindParam(":userId", $userId);
    $stmt->bindParam(":eventId", $eventId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::PARAM_BOOL);

    $isRegistered = $user ? true : false;

    return $isRegistered;
  }



  // Send email to registered users public function!
  public function sendEmailToRegisteredUsers($body, $subscriptions)
  {
    foreach ($subscriptions as $subscription) {
      if ($subscription["lang"] === "Hu") {
        $this->mailer->send($subscription["email"], $body["mail-body-Hu"], "Üzenet");
      } else if ($subscription["lang"] === "En") {
        $this->mailer->send($subscription["email"], $body["mail-body-En"], "Message");
      }
    }
  }




  // GET EVENT DATES BY EVENT ID
  public function getEventDates($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_dates WHERE eventRefId = :id ORDER BY date ASC");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $dates;
  }





























  // SEND MAIL TO REGISTERED USER WHO IS ACCEPTED!

  private function sendMailForRegisteredUsers($eventId)
  {
    $stmt = $this->pdo->prepare("SELECT `name`, `email`,`lang` FROM `users` WHERE `permission` = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
      $body = file_get_contents("./app/views/templates/event_notification/EventNotificationMailTemplate" . $user["lang"] . ".php");
      $body = str_replace('{{name}}', $user["name"], $body);
      $body = str_replace('{{id}}', $eventId, $body);
      $this->mailer->send($user["email"], $body, $user["lang"] === "Hu" ? "Új esemény" : "New event!");
    }
  }


  public function sendMailToSub($body, $subId)
  {

    $sub = self::getRegisteredUser($subId);
    $this->mailer->send($sub["email"], $body["mail-body"], $sub["lang"] === "Hu" ? "Üzenet" : "Message");

    $this->alert->set(
      'Email kiküldése sikeres!',
      'Successful email sent!',
      null,
      'success',
      "/admin/event/subscriber/$subId"
    );
  }




  // UPDATE EVENT DATES BY EVENT ID

  private function updateEventDates($id, $event_dates)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_dates` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertDatesOfEvent($id, $event_dates);
  }

  // INSERT EVENT DATES


  private function insertDatesOfEvent($id, $event_dates)
  {

    foreach ($event_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_dates` VALUES (NULL, :date, :eventRefId);");
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }

  // GET ALL LINKS OF EVENTS

  public function getEventLinks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_links WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  // UPDATE EVENT LINKS BY EVENT ID

  private function updateEventLinks($id, $links)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_links` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertLinksOfEvent($id, $links);
  }

  // INSERT EVENT LINKS

  private function insertLinksOfEvent($id, $links)
  {
    foreach ($links as $link) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_links` VALUES (NULL, :link, :eventRefId);");
      $stmt->bindParam(':link', $link);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }


  // TASKS

  // GET ALL TASKS OF EVENTS

  public function getEventTasks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_tasks WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  // UPDATE TASKS BY EVENT

  private function updateEventTasks($id, $tasks)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_tasks` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertTasksOfEvent($id, $tasks);
  }

  // INSERT TASK OF EVENT
  private function insertTasksOfEvent($id, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_tasks` VALUES (NULL, :task, :eventRefId);");
      $stmt->bindParam(':task', $task);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }


  public function acceptUserSubscription($subId)
  {
    $stmt = $this->pdo->prepare("UPDATE `registrations` SET `isAccepted` = '1' WHERE `registrations`.`id` = :subId;");
    $stmt->bindParam(":subId", $subId);
    $stmt->execute();

    $this->alert->set('Eseményre való regisztráció elfogadva!', null, null, "success", "/admin/event/subscriber/$subId");
  }

  public function deleteUserSubscription($subId)
  {
    $stmt = $this->pdo->prepare("UPDATE `registrations` SET `isAccepted` = '0' WHERE `registrations`.`id` = :subId;");
    $stmt->bindParam(":subId", $subId);
    $stmt->execute();

    $this->alert->set('Elfogadott regisztráció visszavonva!', null, null, "success", "/admin/event/subscriber/$subId");
  }
}
