<?php class EventModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `documents` ORDER BY `createdAt`");
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $documents;
  }

  public function new($files, $body)
  {

    $fileName = $this->fileSaver->saver($files["image"], "/uploads/images/events", null);
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_var($body["date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $links = $body["links"] ?? [];
    $event_dates = $body["event_dates"] ?? [];

    $tasks = $body["task"] ?? [];
    $createdAt = time();


    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `events` VALUES (NULL, :nameInHu, :nameInEn, :descriptionInHu, :descriptionInEn, :date, :fileName, :createdAt)");
    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();

    $lastId = $this->pdo->lastInsertId();
    if ($lastId) {
      self::insertLinksOfEvent($lastId, $links);
      self::insertDatesOfEvent($lastId, $event_dates);
      self::insertTasksOfEvent($lastId, $tasks);
    }


    self::sendMailForRegisteredUsers();


    header("Location: /admin/events");
  }



  public function delete($id)
  {
    $fileNameForDelete = self::getEventById($id)["fileName"];
    unlink("./public/assets/uploads/images/events/$fileNameForDelete");



    $stmt = $this->pdo->prepare("DELETE FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/events");
  }

  public function update($id, $body, $files)
  {
    $prevImage = self::getEventById($id)["fileName"];


    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_var($body["date"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $links = $body["links"] ?? [];
    $event_dates = $body["event_dates"] ?? [];

    $tasks = $body["task"] ?? [];
    $createdAt = time();

    $fileName = '';



    if ($files["image"]["name"] !== '') {
      unlink("./public/assets/uploads/images/events/$prevImage");
      $fileName = $this->fileSaver->saver($files["image"], "/uploads/images/events", null);
    } else {
      $fileName = $prevImage;
    }



    $stmt = $this->pdo->prepare("UPDATE `events` SET 
    `nameInHu` = :nameInHu, 
    `nameInEn` = :nameInEn, 
    `descriptionInHu` = :descriptionInHu, 
    `descriptionInEn` = :descriptionInEn, 
    `date` = :date, 
    `fileName` = :fileName, 
    `createdAt` = :createdAt 
    WHERE `events`.`eventId` = :id");

    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    self::updateEventLinks($id, $links);
    self::updateEventDates($id, $event_dates);
    self::updateEventTasks($id, $tasks);
    
    header("Location:  /admin/events");
  }
  

  public function getEvents()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM events");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  public function getEventById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM events WHERE eventId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetch(PDO::FETCH_ASSOC);

    return $events;
  }

  public function getEventDates($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_dates WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  public function getEventLinks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_links WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  public function getEventTasks($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM event_tasks WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $events;
  }

  private function updateEventLinks($id, $links)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_links` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertLinksOfEvent($id, $links);
  }

  private function updateEventDates($id, $event_dates)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_dates` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertDatesOfEvent($id, $event_dates);
  }

  private function updateEventTasks($id, $tasks)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `event_tasks` WHERE eventRefId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertTasksOfEvent($id, $tasks);
  }

  private function insertLinksOfEvent($id, $links)
  {
    foreach ($links as $link) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_links` VALUES (NULL, :link, :eventRefId);");
      $stmt->bindParam(':link', $link);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }
  private function insertDatesOfEvent($id, $event_dates)
  {

    foreach ($event_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_dates` VALUES (NULL, :date, :eventRefId);");
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }
  
  private function insertTasksOfEvent($id, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `event_tasks` VALUES (NULL, :task, :eventRefId);");
      $stmt->bindParam(':task', $task);
      $stmt->bindParam(':eventRefId', $id);
      $stmt->execute();
    }
  }

  private function sendMailForRegisteredUsers() {
    $stmt = $this->pdo->prepare("SELECT `email` FROM `users`");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($users as $user) {
      $this->mailer->send($user["email"], "Új esemény!", "Hello");
    
    }
  }
}