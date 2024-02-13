<?php
require_once 'app/helpers/UUID.php';
require_once 'app/helpers/Alert.php';
require_once 'app/helpers/Validate.php';


// ONLY USER NOT ADMIN!

class Subscription_Model
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
  public function subscribe($eventId, $body, $files, $user)
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
      $this->alert->set("Minden mező kitöltése kötelező!", "Filling out every field is mandatory!", null, "danger", "/event/subscribe/$eventId");
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
        $this->alert->set(
          "Ezzel a profillal már regisztráltál erre az eseményre!",
          "You have already registered for this event with this profile!",
          null,
          "danger",
          "/event/subscribe/$eventId"
        );
      }



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
        self::copyDocumentFromUserToSubscribe($lastInsertedId, $user["documents"]);
        self::copyLanguagesFromUserToSubscribe($lastInsertedId, $user["langs"]);
        self::insertDatesOfSubscription($lastInsertedId, $dates);
        self::insertTasksOfSubscription($lastInsertedId, $tasks);
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

      $this->alert->set("Az eseményre sikeresen regisztráltál!", "You have successfully registered for the event!", null, "success", "/");
    }


    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null, null);

    if (in_array(false, $documentName)) {
      self::setPrevContent();

      $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/event/subscribe/$eventId");
    }

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
      $this->setPrevContent();
      $this->alert->set(
        "Ezzel az email címmel már regisztráltál erre az eseményre!",
        "You have already registered for this event with this profile!",
        null,
        "danger",
        "/event/subscribe/$eventId"
      );
    }


    if (!$dates || !$tasks) {
      header("Location: /event/subscribe/" . $eventId);
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
      self::insertDatesOfSubscription($lastInsertedId, $dates);
      self::insertTasksOfSubscription($lastInsertedId, $tasks);
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


    if (isset($_SESSION["subErrors"])) unset($_SESSION["subErrors"]);
    if (isset($_SESSION["prevSubContent"])) unset($_SESSION["prevSubContent"]);

    $this->alert->set("Az eseményre sikeresen regisztráltál!", "You have successfully registered for the event!", null, "success", "/");
  }



  // USER DELETE SELF FROM EVENT WITH MAIL URL
  public function deleteSubscriptionFromMailUrl($id)
  {


    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.registrationId = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $sub = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<pre>";

    var_dump($sub);

    if (!$sub) {
      $this->alert->set("Ilyen regisztráció nem létezik!", "Registratinon doesn't exist!", null, "danger", "/");
    };

    self::checkIsEventRegistrationExpired(array($sub), 7);


    $stmt = $this->pdo->prepare("DELETE FROM `registrations` WHERE `registrationId` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();



    $this->alert->set("Esemény regisztráció sikeresen törölve!", "Event subscription deleted succesfully!", null, "success", "/");
  }


  public function acceptUserSubscription($subId)
  {
    $stmt = $this->pdo->prepare("UPDATE `registrations` SET `isAccepted` = '1' WHERE `registrations`.`id` = :subId;");
    $stmt->bindParam(":subId", $subId);
    $stmt->execute();

    $this->alert->set('Eseményre való regisztráció elfogadva!', 'Eseményre való regisztráció elfogadva!', 'Eseményre való regisztráció elfogadva!', "success", "/admin/event/subscriber/$subId");
  }


  public function declineUserSubscription($subId)
  {
    $stmt = $this->pdo->prepare("UPDATE `registrations` SET `isAccepted` = '0' WHERE `registrations`.`id` = :subId;");
    $stmt->bindParam(":subId", $subId);
    $stmt->execute();

    $this->alert->set('Elfogadott regisztráció visszavonva!', 'Elfogadott regisztráció visszavonva!', 'Elfogadott regisztráció visszavonva!', "success", "/admin/event/subscriber/$subId");
  }

  // GET ALL REGISTRATIONS BY EVENT

  public function getSubscriptionsByEvent($eventId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE eventRefId = :id");
    $stmt->bindParam(":id", $eventId);
    $stmt->execute();
    $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $subscriptions;
  }

  // Send email to registered users public function!
  public function sendEmailToSubbedUsers($body, $subscriptions, $eventId)
  {
    foreach ($subscriptions as $subscription) {
      if ($subscription["lang"] === "Hu") {
        $this->mailer->send($subscription["email"], $body["mail-body-Hu"], "Üzenet");
      } else if ($subscription["lang"] === "Sp") {
        $this->mailer->send($subscription["email"], $body["mail-body-Sp"], "");
      } else {
        $this->mailer->send($subscription["email"], $body["mail-body-En"], "Message");
      }
    }

    $this->alert->set('Emailek sikeresen kiküldve!', 'Emailek sikeresen kiküldve!', 'Emailek sikeresen kiküldve!', "success", "/admin/event/$eventId");
  }

  public function sendMailToSub($body, $subId)
  {

    $sub = self::getSubbedUserById($subId); // ez volt getRegisteredUser
    $this->mailer->send($sub["email"], $body["mail-body"], $sub["lang"] === "Hu" ? "Üzenet" : "Message");

    $this->alert->set(
      'Email kiküldése sikeres!',
      'Successful email sent!',
      null,
      'success',
      "/admin/event/subscriber/$subId"
    );
  }




  // USER DELETE SELF FROM EVENT
  public function deleteSubscription($eventId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.eventRefId = :eventRefId");

    $stmt->bindParam(":eventRefId", $eventId);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $this->pdo->prepare("DELETE FROM `registrations` WHERE `eventRefId` = :eventId");
    $stmt->bindParam(":eventId", $eventId);
    $stmt->execute();

    self::checkIsEventRegistrationExpired($subs, 6);


    header("Location: /user/dashboard");
  }















  public function getSubscriptionsByUser($userId)
  {
    $stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `id` = :id");
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $email = $stmt->fetch(PDO::FETCH_ASSOC)["email"];


    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.email = :email");

    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $registrations;
  }





  // GET REGISTERED USER DATA BY ID
  public function getSubbedUserById($id)
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





































  public function addDocumentOfSubscriptions($documentName, $typeOfDocument, $extension, $userRefId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE `registrations`.`userRefId` = :userRefId");
    $stmt->bindParam(':userRefId', $userRefId, PDO::PARAM_STR);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subs as $sub) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_documents` VALUES (NULL, :name, :type, :extension, :registerRefId);");
      $stmt->bindParam(':name', $documentName);
      $stmt->bindParam(':type', $typeOfDocument);
      $stmt->bindParam(':extension',  $extension);
      $stmt->bindParam(':registerRefId', $sub["id"]);

      $stmt->execute();
    }
    self::checkIsEventRegistrationExpired($subs, 5);
  }


  public function deleteDocumentOfSubscription($documentName)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `registration_documents` 
    INNER JOIN registrations ON registration_documents.registerRefId = registrations.id 
    INNER JOIN events ON registrations.eventRefId = events.eventId
    WHERE `registration_documents`.`name` = :documentName");

    $stmt->bindParam(':documentName', $documentName, PDO::PARAM_STR);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);


    self::checkIsEventRegistrationExpired($subs, 3);


    $stmt = $this->pdo->prepare("DELETE FROM `registration_documents` WHERE `registration_documents`.`name` = :documentName");
    $stmt->bindParam(":documentName", $documentName);
    $stmt->execute();
  }


  public function updateSubDocument($prevImage, $documentName,  $typeOfDocument, $extension, $userId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registration_documents` 
    INNER JOIN registrations ON registration_documents.registerRefId = registrations.id 
    INNER JOIN events ON registrations.eventRefId = events.eventId
    WHERE `registration_documents`.`name` = :prevImage");

    $stmt->bindParam(':prevImage', $prevImage, PDO::PARAM_STR);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);



    foreach ($subs as $sub) {
      $stmt = $this->pdo->prepare("UPDATE `registration_documents`
    SET `name` = :name,
        `type` = :type,
        `extension` = :extension
    WHERE `registration_documents`.`name` = :prevImage 
    AND `registration_documents`.`registerRefId` = :registerRefId ");


      $stmt->bindParam(":name", $documentName);
      $stmt->bindParam(":type", $typeOfDocument);
      $stmt->bindParam(":extension", $extension);
      $stmt->bindParam(":prevImage", $prevImage);
      $stmt->bindParam(":registerRefId", $sub["registerRefId"]);
      $stmt->execute();
    }


    self::checkIsEventRegistrationExpired($subs, 4);
  }




  public function checkIsEventRegistrationExpired($subs, $state)
  {
    echo "<pre>";
    $now = date('Y-m-d');

    switch ($state) {
      case 1:
        $state = "Frissítette a profilját!"; // DONE
        break;

      case 2:
        $state = "Törölte a profilját!"; // 
        break;

      case 3:
        $state = "Törölte egy dokumentumát!"; // DONE
        break;

      case 4:
        $state = "Frissítette egy dokumentumát"; // DONE
        break;
      case 5:
        $state =  "Új dokumentumot adott hozzá"; // DONE
        break;
      case 6:
        $state =  "Törölte az esemény regisztrációját"; // DONE
        break;
      case 7:
        $state =  "Törölte az esemény regisztrációját emailből"; // DONE
        break;
      default:
        $state = "Valami nem ok";
        break;
    }


    foreach ($subs as $sub) {
      if ($sub["reg_end_date"] <= $now) {
        $body = "
          <div style='background: #ec0677; color: white; padding: 3rem' >
          <h1>
          Kedves admin!
          </h1> 
         <p style='font-size: 1.2rem'>
          Tájékoztatlak hogy a <b>" . $sub["id"] . " id</b>-val rendelkező 
          <b>" . $sub["name"] .  " nevű</b> <br>
          felhasználó a regisztráció lezárta után <b>$state</b>. 
          <br>
          Ez érinti  a
          <b>" .  $sub["eventRefId"]  . " id</b>-jú
          <b>" .  $sub["nameInHu"]  . " </b> eseményt!.
         </p>
          </div>";
        $this->mailer->send("developedbybarley@gmail.com", $body, "Tájékoztatás");
      }
    }
  }

  public function userDeleteSubsAndSelf($userId)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE `registrations`.`userRefId` = :id");


    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    self::checkIsEventRegistrationExpired($subs, 2);

  }

  public function updateUserDataOfSubscription($body, $userId)
  {


    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $informedBy = filter_var(INFORMED_BY["inform"][$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];

    $lang = $_COOKIE["lang"] ?? null;


    // Prepare statement
    $stmt = $this->pdo->prepare("
    UPDATE `registrations`
    SET 
        `name` = :name,
        `address` = :address,
        `mobile` = :mobile,
        `profession` = :profession,
        `schoolName` = :schoolName,
        `otherLanguages` = :otherLanguages,
        `informedBy` = :informedBy,
        `permission` = :permission,
        `lang` = :lang
    WHERE `registrations`.`userRefId` = :id
");

    // Bind parameters
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $stmt->bindParam(':profession', $profession, PDO::PARAM_STR);
    $stmt->bindParam(':schoolName', $school_name, PDO::PARAM_STR);
    $stmt->bindParam(':otherLanguages', $otherLanguages, PDO::PARAM_STR);
    $stmt->bindParam(':informedBy', $informedBy, PDO::PARAM_STR);
    $stmt->bindParam(':permission', $permission, PDO::PARAM_INT);
    $stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

    // Execute statement
    $stmt->execute();

    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE `registrations`.`userRefId` = :id");

    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);




    self::updateSubLanguages($languages, $levels, array_column($subs, "id"));

    self::checkIsEventRegistrationExpired($subs, 1);
  }




  function updateSubLanguages($languages, $levels, $arrayOfSubId)
  {

    foreach ($arrayOfSubId as $subId) {

      $stmt = $this->pdo->prepare("DELETE FROM `registration_languages` WHERE `registration_languages`.`registerRefId` = :id");
      $stmt->bindParam(":id", $subId);
      $stmt->execute();

      self::insertLanguages($subId, $languages, $levels);
    }
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
  private function copyLanguagesFromUserToSubscribe($registerId, $languages)
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
  private function copyDocumentFromUserToSubscribe($registerId, $documents)
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

  private function insertDatesOfSubscription($registerId, $registration_dates)
  {

    foreach ($registration_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_dates` VALUES (NULL, :date, :registerRefId);");
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }

  // INSERT TASKS WHEN USER REGISTER TO EVENT


  private function insertTasksOfSubscription($registerId, $tasks)
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

  // SET PREV CONTENT BEFORE REDIRECT
  private function setPrevContent()
  {
    $langs = $_POST["langs"];
    $levels = $_POST["levels"];
    $userLanguages = [];


    // POST langs átalakítása a megfelelő formátumra!
    for ($i = 0; $i < count($langs); $i++) {
      $userLanguages[] = [
        "lang" => $langs[$i],
        "level" => $levels[$i]
      ];
    }


    $_POST["userLanguages"] = $userLanguages;
    $_SESSION["prevSubContent"] = $_POST;
  }
}
