
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
    $stmt->bindParam(":today", $today, PDO::PARAM_STR);
    $stmt->execute();
  }

  private function setEventsPublic()
  {
    $today = date("Y-m-d");


    $stmt = $this->pdo->prepare("UPDATE events SET `isPublic` = '1' WHERE `isPublic` = '0' AND (`date` > :today OR `reg_end_date` > :today)");
    $stmt->bindParam(":today", $today, PDO::PARAM_STR);
    $stmt->execute();
  }

  // SET EVENT STATE BY $_GET PARAMETER / PUBLIC | PRIVATE
  public function state($id, $state)
  {
    $stmt = $this->pdo->prepare("UPDATE `events` SET `isPublic` = :state WHERE `events`.`eventId` = :id");
    $stmt->bindParam(":state", $state, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
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

     if (!$fileName) {
        $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/admin/events/new");
      }

    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_var($body["date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $end_date = filter_var($body["end_date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $reg_end_date = filter_var($body["reg_end_date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = filter_var($body["slug"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $links = $body["links"] ?? [];
    $event_dates = $body["event_dates"] ?? [];
    $isPublic = 1;
    $tasks = $body["task"] ?? [];
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `events` VALUES (NULL, :nameInHu, :nameInEn, :descriptionInHu, :descriptionInEn, :date, :end_date, :reg_end_date, :isPublic, :fileName, :createdAt, :slug)");
    $stmt->bindParam(":nameInHu", $nameInHu, PDO::PARAM_STR);
    $stmt->bindParam(":nameInEn", $nameInEn, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn, PDO::PARAM_STR);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":end_date", $end_date, PDO::PARAM_STR);
    $stmt->bindParam(":reg_end_date", $reg_end_date, PDO::PARAM_STR);
    $stmt->bindParam(":isPublic", $isPublic, PDO::PARAM_INT);
    $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":createdAt", $createdAt, PDO::PARAM_INT);
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

    $stmt->execute();

    $lastId = $this->pdo->lastInsertId();
    if ($lastId) {
      self::insertLinksOfEvent($lastId, $links);
      self::insertDatesOfEvent($lastId, $event_dates);
      self::insertTasksOfEvent($lastId, $tasks);
    }


    self::sendMailForRegisteredUsers($lastId);

    $this->alert->set('Új esemény sikeresen hozzáadva!', 'Új esemény sikeresen hozzáadva!', 'Új esemény sikeresen hozzáadva!', "success", "/admin/events");
  }


  // DELETE EVENT

  public function delete($id)
  {
    $fileNameForDelete = self::getEventById($id)["fileName"];
    unlink("./public/assets/uploads/images/events/$fileNameForDelete");



    $stmt = $this->pdo->prepare("DELETE FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
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
    $slug = filter_var($body["slug"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $links = $body["links"] ?? [];
    $event_dates = $body["event_dates"] ?? [];

    $tasks = $body["task"] ?? [];

    $fileName = '';



    if ($files["image"]["name"] !== '') {
      $fileName = $this->fileSaver->saver($files["image"], "/uploads/images/events", null, [
        'image/png',
        'image/jpeg',
      ]);
      if (!$fileName) {
        $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/admin/events/update/" . $id);
      }
      unlink("./public/assets/uploads/images/events/$prevImage");
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
    `createdAt` = :createdAt, 
    `slug` = :slug
    WHERE `events`.`eventId` = :id");

    $stmt->bindParam(":nameInHu", $nameInHu, PDO::PARAM_STR);
    $stmt->bindParam(":nameInEn", $nameInEn, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn, PDO::PARAM_STR);
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmt->bindParam(":end_date", $end_date, PDO::PARAM_STR);
    $stmt->bindParam(":reg_end_date", $reg_end_date, PDO::PARAM_STR);
    $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":createdAt", $createdAt, PDO::PARAM_INT);
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    self::updateEventLinks($id, $links);
    self::updateEventDates($id, $event_dates);
    self::updateEventTasks($id, $tasks);
    self::setEventsPublic();

    $this->alert->set('Esemény sikeresen frissítve!', 'Esemény sikeresen frissítve!', 'Esemény sikeresen frissítve!', "success", "/admin/events");
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
      $stmt->bindParam(":id", $event["eventId"], PDO::PARAM_INT);
      $stmt->execute();
      $events[$index]["subscriptions"] = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    }

    return $admin ?  [
      "numOfPage" => $numOfPage,
      "events" => $events
    ] : $events;
  }


  // GET EVENT BY ID IF ADMIN | USER

  public function getEventBySlug($slug)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE slug = :slug");
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    return $event;
  }


  public function getEventById($id, $admin = null)
  {

    if (!$admin || !isset($admin)) {
      $stmt = $this->pdo->prepare("SELECT * FROM events WHERE eventId = :id AND `isPublic` = '1'");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $event = $stmt->fetch(PDO::FETCH_ASSOC);

      return $event;
    }

    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    return $event;
  }



  // GET LATEST EVENT FOR CONTENT PAGE
  public function getLatestEvents()
  {
    $today = date("Y-m-d");

    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE (`isPublic` = '1') AND (`date` > :today OR `reg_end_date` > :today) ORDER BY `date` ASC LIMIT 6");
    $stmt->bindParam(":today", $today, PDO::PARAM_STR);
    $stmt->execute();
    $event = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $event;
  }

  // REGISTRATIONS









  public function checkIsUserRegisteredToEvent($eventId, $userId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` WHERE `userRefId` = :userId AND `eventRefId` = :eventId");
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":eventId", $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::PARAM_BOOL);

    $isRegistered = $user ? true : false;

    return $isRegistered;
  }








  // GET EVENT DATES BY EVENT ID
  public function getEventDates($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_dates WHERE eventRefId = :id ORDER BY date ASC");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
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
      $body = str_replace('{{url}}', CURRENT_URL, $body);
      $this->mailer->send($user["email"], $body, $user["lang"] === "Hu" ? "Új esemény" : "New event!");
    }
  }







  // UPDATE EVENT DATES BY EVENT ID

  private function updateEventDates($id, $event_dates)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_dates` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    self::insertDatesOfEvent($id, $event_dates);
  }

  // INSERT EVENT DATES


  private function insertDatesOfEvent($id, $event_dates)
  {

    foreach ($event_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_dates` VALUES (NULL, :date, :eventRefId);");
      $stmt->bindParam(':date', $date, PDO::PARAM_STR);
      $stmt->bindParam(':eventRefId', $id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  // GET ALL LINKS OF EVENTS

  public function getEventLinks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_links WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  // UPDATE EVENT LINKS BY EVENT ID

  private function updateEventLinks($id, $links)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_links` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    self::insertLinksOfEvent($id, $links);
  }

  // INSERT EVENT LINKS

  private function insertLinksOfEvent($id, $links)
  {
    foreach ($links as $link) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_links` VALUES (NULL, :link, :eventRefId);");
      $stmt->bindParam(':link', $link, PDO::PARAM_STR);
      $stmt->bindParam(':eventRefId', $id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }


  // TASKS

  // GET ALL TASKS OF EVENTS

  public function getEventTasks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_tasks WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  // UPDATE TASKS BY EVENT

  private function updateEventTasks($id, $tasks)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_tasks` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    self::insertTasksOfEvent($id, $tasks);
  }

  // INSERT TASK OF EVENT
  private function insertTasksOfEvent($id, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_tasks` VALUES (NULL, :task, :eventRefId);");
      $stmt->bindParam(':task', $task, PDO::PARAM_INT);
      $stmt->bindParam(':eventRefId', $id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
}
