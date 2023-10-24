<?php
require_once 'app/helpers/UUID.php';
require_once 'app/helpers/Alert.php';

// ONLY USER NOT ADMIN!

class UserEventModel
{
  private $pdo;
  private $fileSaver;
  private $mailer;
  private $uuid;
  private $alert;
  private $eventModel;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
    $this->uuid = new UUID();
    $this->alert = new Alert();
    $this->eventModel = new EventModel();
  }



  // USER REGISTER TO EVENT
  public function register($eventId, $body, $files, $user)
  {
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];
    $tasks = $body["tasks"] ?? null;
    $dates = $body["dates"] ?? null;
    $lang = $_COOKIE["lang"] ?? null;
    $rand = $this->uuid->generateUUID();
    $event = $this->eventModel->getEventById($eventId);
    $isAccepted = 0;
    $tasksInLang = [];


    // CONVERT TASK TO STRING FOR MAIL
    foreach ($tasks as $index => $task) {
      $tasksInLang[$index] = TASK_AREAS["areas"][$task][$lang];
    }

    $tasksInString = implode(",<br>", $tasksInLang);

    if (!$dates || !$tasks) {
      $this->alert->set("Minden mező kitöltése kötelező!", "danger", "/event/register/$eventId");
    }

    // CHECK USER IS EXIST

    if ($user) {
      $stmt = $this->pdo->prepare("SELECT `name`, `email` FROM `registrations` WHERE `name` = :name AND `email` = :email AND `eventRefId` = :eventId");
      $stmt->bindParam(":name", $user["name"]);
      $stmt->bindParam(":email", $user["email"]);
      $stmt->bindParam(":eventId", $eventId);
      $stmt->execute();
      $isUserExist = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!empty($isUserExist)) {
        $this->alert->set("Ezzel a profillal már regisztráltál erre az eseményre!", "danger", "/event/register/$eventId");
      }


      // INSERT USER IF USER EXIST

      $stmt = $this->pdo->prepare("INSERT INTO `registrations` 
      VALUES 
      (NULL, :registrationId, :name, :email, :address , :mobile, :profession, :schoolName, :otherLanguages, :participation, :informedBy, :permission, :lang, :isAccepted ,:fileName, :userRefId, :eventRefId);");

      $stmt->bindParam(":name", $user["name"]);
      $stmt->bindParam(":registrationId", $rand);
      $stmt->bindParam(":email",  $user["email"]);
      $stmt->bindParam(":address", $user["address"]);
      $stmt->bindParam(":mobile", $user["mobile"]);
      $stmt->bindParam(":profession", $user["profession"]);
      $stmt->bindParam(":schoolName", $user["schoolName"]);
      $stmt->bindParam(":otherLanguages", $user["otherLanguages"]);
      $stmt->bindParam(":participation", $user["participation"]);
      $stmt->bindParam(":informedBy", $user["informedBy"]);
      $stmt->bindParam(":permission", $user["permission"]);
      $stmt->bindParam(":lang", $lang);
      $stmt->bindParam(":isAccepted", $isAccepted);
      $stmt->bindParam(":fileName", $user["fileName"]);
      $stmt->bindParam(":userRefId", $user["id"]);
      $stmt->bindParam(":eventRefId", $eventId);
      $stmt->bindParam(":eventRefId", $eventId);

      $stmt->execute();

      $lastInsertedId = $this->pdo->lastInsertId();


      if ($lastInsertedId) {
        self::copyDocumentFromUserToRegister($lastInsertedId, $user["documents"]);
        self::copyLanguagesFromUserToRegister($lastInsertedId, $user["langs"]);
        self::insertDatesOfRegistration($lastInsertedId, $dates);
        self::insertTasksOfRegistration($lastInsertedId, $tasks);
      }



      // GENERATE MAIL FORM AND SEND IF USER EXIST
      $body = file_get_contents("./app/views/templates/event_subscription/EventSubscriptionMailTemplate" . $user["lang"] . ".php");
      $body = str_replace('{{name}}', $user["name"], $body);
      $body = str_replace('{{email}}', $user["email"], $body);
      $body = str_replace('{{address}}', $user["address"], $body);
      $body = str_replace('{{mobile}}', $user["email"], $body);
      $body = str_replace('{{dates}}', implode(", ", $dates), $body);
      $body = str_replace('{{event_name}}', $event["nameIn" . $user["lang"]], $body);
      $body = str_replace('{{start_date}}', $event["date"], $body);
      $body = str_replace('{{end_date}}', $event["end_date"], $body);
      $body = str_replace('{{tasks}}', $tasksInString, $body);
      $body = str_replace('{{id}}', $rand, $body);


      $this->mailer->send($user["email"], $body, $user["lang"] === "Hu" ? "Esemény regisztráció!" : "Event registration");



      // Redirect to success!
      $_SESSION["success"] = [
        "title" => "Köszönjük a regisztrációdat!",
        "message" => "Az eseményre való regisztráció megtörtént! Az e-mail címére visszaigazoló levelet küldtünk!",
        "button_message" => "Vissza a főoldalra",
        "path" => "/",
      ];
      header("Location: /success");


      return;
    }


    // IF USER DOESN'T EXIST

    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null, [
      'application/pdf',
      'application/msword',
    ]);

    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($body["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $participation = filter_var($body["participation"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $informedBy = filter_var(INFORMED_BY["inform"][$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
    $typeOfDocuments = $body["typeOfDocument"] ?? [];
    $levels = $body["levels"] ?? [];

    $documents = self::formatDocuments($documentName, $typeOfDocuments);




    $stmt = $this->pdo->prepare("SELECT `name`, `email` FROM `registrations` WHERE `name` = :name AND `email` = :email");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $isUserExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($isUserExist)) {
      echo "Ezzel a profillal már regisztráltál erre az eseményre";
      exit;
    }


    if (!$dates || !$tasks) {
      header("Location: /event/register/" . $eventId);
      exit;
    }

    $stmt = $this->pdo->prepare("INSERT INTO `registrations` 
    VALUES 
    (NULL, :registrationId, :name, :email, :address , :mobile, :profession, :schoolName, :otherLanguages, :participation, :informedBy, :permission, :lang, :isAccepted, NULL, NULL, :eventRefId);");

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":registrationId", $rand);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":mobile", $mobile);
    $stmt->bindParam(":profession", $profession);
    $stmt->bindParam(":schoolName", $school_name);
    $stmt->bindParam(":otherLanguages", $otherLanguages);
    $stmt->bindParam(":participation", $participation);
    $stmt->bindParam(":informedBy", $informedBy);
    $stmt->bindParam(":permission", $permission);
    $stmt->bindParam(":lang", $lang);
    $stmt->bindParam(":isAccepted", $isAccepted);
    $stmt->bindParam(":eventRefId", $eventId);

    $stmt->execute();

    $lastInsertedId = $this->pdo->lastInsertId();


    if ($lastInsertedId) {
      self::insertLanguages($lastInsertedId, $languages, $levels);
      self::insertDatesOfRegistration($lastInsertedId, $dates);
      self::insertTasksOfRegistration($lastInsertedId, $tasks);
      self::insertDocuments($lastInsertedId, $documents);
    }

    $body = file_get_contents("./app/views/templates/event_subscription/EventSubscriptionMailTemplate" . $lang . ".php");
    $body = str_replace('{{name}}', $name, $body);
    $body = str_replace('{{email}}', $email, $body);
    $body = str_replace('{{address}}', $address, $body);
    $body = str_replace('{{mobile}}', $email, $body);
    $body = str_replace('{{dates}}', implode(", ", $dates), $body);
    $body = str_replace('{{event_name}}', $event["nameIn" . $lang], $body);
    $body = str_replace('{{start_date}}', $event["date"], $body);
    $body = str_replace('{{end_date}}', $event["end_date"], $body);
    $body = str_replace('{{tasks}}', $tasksInString, $body);
    $body = str_replace('{{id}}', $rand, $body);

    $this->mailer->send($email, $body, $lang === "Hu" ? "Event regisztráció!" : "Event registration");

    $_SESSION["success"] = [
      "title" => "Köszönjük a regisztrációdat!",
      "message" => "Az eseményre való regisztráció megtörtént! Az e-mail címére visszaigazoló levelet küldtünk!",
      "button_message" => "Vissza a főoldalra",
      "path" => "/",
    ];
    header("Location: /success");
  }

  // USER DELETE SELF FROM EVENT
  public function delete($eventId)
  {

    $stmt = $this->pdo->prepare("DELETE FROM `registrations` WHERE `eventRefId` = :eventId");
    $stmt->bindParam(":eventId", $eventId);
    $stmt->execute();


    header("Location: /user/dashboard");
  }

  // USER DELETE SELF FROM EVENT WITH MAIL
  public function deleteRegistrationFromMailUrl($id)
  {

    $stmt = $this->pdo->prepare("SELECT  `registrationId` FROM `registrations` WHERE `registrationId` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $isSubExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$isSubExist) {
      echo "Ilyen regisztráció nem létezik!";
      exit;
    }


    $stmt = $this->pdo->prepare("DELETE FROM `registrations` WHERE `registrationId` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
  }

  // INSERT LANGUAGES WHEN USER REGISTER TO EVENT

  private function insertLanguages($registerId, $languages, $levels)
  {

    $ret = [];

    for ($i = 0; $i < count($languages); $i++) {
      $ret[$i] = [
        "lang" => $languages[$i],
        "level" => $levels[$i]
      ];
    }


    foreach ($ret as $language) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_languages` VALUES (NULL, :lang, :level, :registerRefId);");
      $stmt->bindParam(':lang', $language["lang"]);
      $stmt->bindParam(':level', $language["level"]);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }

  // COPY LANGUAGES FROM REGISTRATIONS TABLE WHEN USER EXIST INTO REGISTRATIONS
  private function copyLanguagesFromUserToRegister($registerId, $languages)
  {
    foreach ($languages as $language) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_languages` VALUES (NULL, :lang, :level, :registerRefId);");
      $stmt->bindParam(':lang', $language["lang"]);
      $stmt->bindParam(':level', $language["level"]);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }
 

   // COPY DOCUMENTS FROM REGISTRATIONS TABLE WHEN USER EXIST INTO REGISTRATIONS
  private function copyDocumentFromUserToRegister($registerId, $documents)
  {
    foreach ($documents as $document) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_documents` VALUES (NULL, :name, :type, :extension, :registerRefId);");
      $stmt->bindParam(':name', $document["name"]);
      $stmt->bindParam(':type', $document["type"]);
      $stmt->bindParam(':extension',  $document["extension"]);
      $stmt->bindParam(':registerRefId', $registerId);

      // INSERT parancs végrehajtása
      $stmt->execute();
    }
  }

  // INSERT DATES WHEN USER REGISTER TO EVENT

  private function insertDatesOfRegistration($registerId, $registration_dates)
  {

    foreach ($registration_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_dates` VALUES (NULL, :date, :registerRefId);");
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }

  // INSERT TASKS WHEN USER REGISTER TO EVENT


  private function insertTasksOfRegistration($registerId, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_tasks` VALUES (NULL, :task, :registerRefId);");
      $stmt->bindParam(':task', $task);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }

  


  // INSERT DOCUMENTS WHEN USER REGISTER TO EVENT

  private function insertDocuments($registerId, $documents)
  {

    foreach ($documents as $document) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_documents` VALUES (NULL, :name, :type, :extension, :registerRefId);");
      $extension =  pathinfo($document["file"], PATHINFO_EXTENSION);
      // Paraméterek kötése
      $stmt->bindParam(':name', $document["file"]);
      $stmt->bindParam(':type', $document["type"]);
      $stmt->bindParam(':extension',  $extension);
      $stmt->bindParam(':registerRefId', $registerId);

      // INSERT parancs végrehajtása
      $stmt->execute();
    }
  }



  // FORMAT DOCUMENTS FOR REGISTER TO EVENT
  private function formatDocuments($documentName, $typeOfDocument)
  {

    $ret = [];


    for ($i = 0; $i < count($documentName); $i++) {
      $ret[] = array(
        'file' => $documentName[$i],
        'type' => $typeOfDocument[$i]
      );
    }


    return $ret;
  }
}