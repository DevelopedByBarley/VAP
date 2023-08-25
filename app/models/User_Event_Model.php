<?php
require 'app/helpers/MailBodies.php';


class UserEventModel
{
  private $pdo;
  private $fileSaver;
  private $mailer;
  private $body;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
    $this->body = new MailBodies();
  }





  public function register($eventId, $body, $files, $user)
  {
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];
    $tasks = $body["tasks"] ?? null;
    $dates = $body["dates"] ?? null;



    if ($user) {

      $stmt = $this->pdo->prepare("SELECT `name`, `email` FROM `registrations` WHERE `name` = :name AND `email` = :email");
      $stmt->bindParam(":name", $user["name"]);
      $stmt->bindParam(":email", $user["email"]);
      $stmt->execute();
      $isUserExist = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!empty($isUserExist)) {
        echo "Ezzel a profillal már regisztráltál erre az eseményre";
        exit;
      }



      $stmt = $this->pdo->prepare("INSERT INTO `registrations` 
      VALUES 
      (NULL, :name, :email, :address , :mobile, :profession, :schoolName, :otherLanguages, :participation, :informedBy, :permission, :fileName, :userRefId, :eventRefId);");

      $stmt->bindParam(":name", $user["name"]);
      $stmt->bindParam(":email",  $user["email"]);
      $stmt->bindParam(":address", $user["address"]);
      $stmt->bindParam(":mobile", $user["mobile"]);
      $stmt->bindParam(":profession", $user["profession"]);
      $stmt->bindParam(":schoolName", $user["schoolName"]);
      $stmt->bindParam(":otherLanguages", $user["otherLanguages"]);
      $stmt->bindParam(":participation", $user["participation"]);
      $stmt->bindParam(":informedBy", $user["informedBy"]);
      $stmt->bindParam(":permission", $user["permission"]);
      $stmt->bindParam(":fileName", $user["fileName"]);
      $stmt->bindParam(":userRefId", $user["id"]);
      $stmt->bindParam(":eventRefId", $eventId);

      $stmt->execute();

      $lastInsertedId = $this->pdo->lastInsertId();


      if ($lastInsertedId) {
        self::copyDocumentFromUserToRegister($lastInsertedId, $user["documents"]);
        self::copyLanguagesFromUserToRegister($lastInsertedId, $user["langs"]);
        self::insertDatesOfRegistration($lastInsertedId, $dates);
        self::insertTasksOfRegistration($lastInsertedId, $tasks);
      }

      header("Location: /event/success");
      $this->mailer->send($user["email"], $this->body->registrationToEvent(), "Event regisztráció!");

      return;
    }



    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null);

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
    (`id`, `name`, `email`, `address`, `mobile`, `profession`, `schoolName`, `otherLanguages`, `participation`, `informedBy`, `permission`, `userRefId`, `eventRefId`) 
    VALUES 
    (NULL, :name, :email, :address , :mobile, :profession, :schoolName, :otherLanguages, :participation, :informedBy, :permission, NULL, :eventRefId);");

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":mobile", $mobile);
    $stmt->bindParam(":profession", $profession);
    $stmt->bindParam(":schoolName", $school_name);
    $stmt->bindParam(":otherLanguages", $otherLanguages);
    $stmt->bindParam(":participation", $participation);
    $stmt->bindParam(":informedBy", $informedBy);
    $stmt->bindParam(":permission", $permission);
    $stmt->bindParam(":eventRefId", $eventId);

    $stmt->execute();

    $lastInsertedId = $this->pdo->lastInsertId();


    if ($lastInsertedId) {
      self::insertLanguages($lastInsertedId, $languages, $levels);
      self::insertDatesOfRegistration($lastInsertedId, $dates);
      self::insertTasksOfRegistration($lastInsertedId, $tasks);
      self::insertDocuments($lastInsertedId, $documents);
    }

    $this->mailer->send($email, $this->body->registrationToEvent(), "Event regisztráció!");

    header("Location: /event/success");
  }

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


  private function insertDatesOfRegistration($registerId, $registration_dates)
  {

    foreach ($registration_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_dates` VALUES (NULL, :date, :registerRefId);");
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }

  private function insertTasksOfRegistration($registerId, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_tasks` VALUES (NULL, :task, :registerRefId);");
      $stmt->bindParam(':task', $task);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }


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
  private function copyLanguagesFromUserToRegister($registerId, $lanugages)
  {
    foreach ($lanugages as $language) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_languages` VALUES (NULL, :lang, :level, :registerRefId);");
      $stmt->bindParam(':lang', $language["lang"]);
      $stmt->bindParam(':level', $language["level"]);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }



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
