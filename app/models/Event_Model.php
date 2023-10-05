<?php class EventModel
{

  private $pdo;
  private $fileSaver;
  private $mailer;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
  }

  // Set event isPublic = 0 if it expired
  public function setEventsPrivateIfExpired() {
    $today = date("Y-m-d");


    $stmt = $this->pdo->prepare("UPDATE events SET `isPublic` = '0' WHERE `isPublic` = '1' AND (`date` < :today OR `reg_end_date` < :today)");
    $stmt->bindParam(":today", $today);
    $stmt->execute();


  }

  // Set event state by $_GET parameter
  public function state($id, $state)
  {
    $stmt = $this->pdo->prepare("UPDATE `events` SET `isPublic` = :state WHERE `events`.`eventId` = :id");
    $stmt->bindParam(":state", $state);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: /admin/event/$id");
  }



  // Add new event
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
    exit;


    header("Location: /admin/events");
  }


  // Delete event

  public function delete($id)
  {
    $fileNameForDelete = self::getEventById($id)["fileName"];
    unlink("./public/assets/uploads/images/events/$fileNameForDelete");



    $stmt = $this->pdo->prepare("DELETE FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/events");
  }



  // Update event

  public function update($id, $body, $files)
  {
    $event = self::getEventById($id);
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

    header("Location:  /admin/events");
  }





  // Get events by admin or user
  public function index($admin = null)
  {


    $events = [];

    if ($admin) {
      $stmt = $this->pdo->prepare("SELECT * FROM events");
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

    return $events;
  }


  // Get event by id if admin or user

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



  // Get latest event if it current
  public function getLatestEvent()
  {
    $today = date("Y-m-d");

    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE `isPublic` = '1' AND `date` > :today OR `reg_end_date` > :today ORDER BY `date` ASC LIMIT 1");
    $stmt->bindParam(":today", $today);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    return $event;
  }

  // REGISTRATIONS


  // Get all registration by event

  public function getRegistrationsByEvent($eventId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE eventRefId = :id");
    $stmt->bindParam(":id", $eventId);
    $stmt->execute();
    $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $subscriptions;
  }

  // Get registered users by event
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




  // Send email to registered users public function!
  public function sendEmailToRegisteredUsers($body, $subscriptions)
  {

    foreach ($subscriptions as $subscription) {
      if ($subscription["lang"] === "Hu") {
        $this->mailer->send($subscription["email"], $body["mail-body-Hu"], "Hello");
      } else if ($subscription["lang"] === "En") {
        $this->mailer->send($subscription["email"], $body["mail-body-En"], "Hello");
      }
    }
  }





  // DATES 
  public function getEventDates($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_dates WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }






























  // Send email to registered users private function!

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




  // Update event dates

  private function updateEventDates($id, $event_dates)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_dates` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertDatesOfEvent($id, $event_dates);
  }

  // Insert event dates


  private function insertDatesOfEvent($id, $event_dates)
  {

    foreach ($event_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_dates` VALUES (NULL, :date, :eventRefId);");
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }

  // Get event links

  public function getEventLinks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_links WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  // Update event links

  private function updateEventLinks($id, $links)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_links` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertLinksOfEvent($id, $links);
  }

  // Insert event links

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

  // Get tasks of event

  public function getEventTasks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_tasks WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  // Update event tasks

  private function updateEventTasks($id, $tasks)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_tasks` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertTasksOfEvent($id, $tasks);
  }

  // Insert event tasks
  private function insertTasksOfEvent($id, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_tasks` VALUES (NULL, :task, :eventRefId);");
      $stmt->bindParam(':task', $task);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }
}
