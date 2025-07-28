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
      $this->alert->set("Minden mező kitöltése kötelező!", "Filling out every field is mandatory!", null, "danger", "/event/subscribe/" . $event["slug"]);
    }

    // CHECK USER IS EXIST

    if ($user) {
      $stmt = $this->pdo->prepare("SELECT `name`, `email` FROM `registrations` WHERE `email` = :email AND `eventRefId` = :eventId");
      $stmt->bindParam(":email", $user["email"], PDO::PARAM_STR);
      $stmt->bindParam(":eventId", $eventId, PDO::PARAM_INT);
      $stmt->execute();
      $isSubExist = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!empty($isSubExist)) {
        $this->alert->set(
          "Ezzel a profillal már regisztráltál erre az eseményre!",
          "You have already registered for this event with this profile!",
          null,
          "danger",
          "/event/subscribe/" . $event["slug"]
        );
      }





      $stmt = $this->pdo->prepare("INSERT INTO `registrations` 
      VALUES 
      (NULL, :registrationId, :name, :email, :address , :mobile, :profession, :schoolName, :otherLanguages, :participation, :informedBy, :permission, :lang, :isAccepted ,:fileName, :userRefId, :eventRefId);");

      $stmt->bindParam(":name", $user["name"], PDO::PARAM_STR);
      $stmt->bindParam(":registrationId", $rand, PDO::PARAM_STR);
      $stmt->bindParam(":email",  $user["email"], PDO::PARAM_STR);
      $stmt->bindParam(":address", $user["address"], PDO::PARAM_STR);
      $stmt->bindParam(":mobile", $user["mobile"], PDO::PARAM_INT);
      $stmt->bindParam(":profession", $user["profession"], PDO::PARAM_STR);
      $stmt->bindParam(":schoolName", $user["schoolName"], PDO::PARAM_STR);
      $stmt->bindParam(":otherLanguages", $user["otherLanguages"], PDO::PARAM_STR);
      $stmt->bindParam(":participation", $user["participation"], PDO::PARAM_INT);
      $stmt->bindParam(":informedBy", $user["informedBy"], PDO::PARAM_STR);
      $stmt->bindParam(":permission", $user["permission"], PDO::PARAM_INT);
      $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
      $stmt->bindParam(":isAccepted", $isAccepted, PDO::PARAM_INT);
      $stmt->bindParam(":fileName", $user["fileName"], PDO::PARAM_STR);
      $stmt->bindParam(":userRefId", $user["id"], PDO::PARAM_INT);
      $stmt->bindParam(":eventRefId", $eventId, PDO::PARAM_INT);

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
      $body = str_replace('{{url}}', CURRENT_URL, $body);


      $this->mailer->send($user["email"], $body, $user["lang"] === "Hu" ? "Esemény regisztráció!" : "Event registration");

      $this->alert->set("Az eseményre sikeresen regisztráltál!", "You have successfully registered for the event!", null, "success", "/");
    }

    // IF USER DOESNT EXIST------------------------------------------------------------------------------------------------------------------------------------

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

    // CHECK PROFILE AND SUB EXIST
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE email = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $isUserExist = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!empty($isUserExist)) {
      $this->setPrevContent();
      $this->alert->set(
        "Ezekkel az adatokkal nem tudsz regisztrálni erre az eseményre! Kérlek jelentkezz be vagy ellenőrizd az adataidat.",
        "You cannot register for this event with these details! Please log in or check your details.",
        null,
        "danger",
        "/event/subscribe/" . $event["slug"]
      );
    }

    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` WHERE email = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $isSubExist = $stmt->fetch(PDO::FETCH_ASSOC);




    if (!empty($isSubExist)) {
      $this->setPrevContent();
      $this->alert->set(
        "Ezzekkel az adatokkal már regisztráltak erre az eseményre!",
        "You have already registered for this event with these details!",
        null,
        "danger",
        "/event/subscribe/" . $event["slug"]
      );
    }


    if (!$dates || !$tasks) {
      $this->setPrevContent();
      $this->alert->set("Minden mező kitöltése kötelező!", "Filling out every field is mandatory!", null, "danger", "/event/subscribe/" . $event["slug"]);
    }



    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null, null);

    if (in_array(false, $documentName)) {
      self::setPrevContent();
      $this->fileSaver->deleteDeclinedFiles($documentName);


      $this->alert->set("Feltöltött dokumentum file típus elutasítva", "Uploaded document file type rejected", null, "danger", "/event/subscribe/" . $event["slug"]);
    }

    $documents = self::formatDocuments($documentName, $typeOfDocuments);


    $stmt = $this->pdo->prepare("INSERT INTO `registrations` 
    VALUES 
    (NULL, :registrationId, :name, :email, :address , :mobile, :profession, :schoolName, :otherLanguages, :participation, :informedBy, :permission, :lang, :isAccepted, NULL, NULL, :eventRefId);");

    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":registrationId", $rand, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":address", $address, PDO::PARAM_STR);
    $stmt->bindParam(":mobile", $mobile, PDO::PARAM_INT);
    $stmt->bindParam(":profession", $profession, PDO::PARAM_STR);
    $stmt->bindParam(":schoolName", $school_name, PDO::PARAM_STR);
    $stmt->bindParam(":otherLanguages", $otherLanguages, PDO::PARAM_STR);
    $stmt->bindParam(":participation", $participation, PDO::PARAM_INT);
    $stmt->bindParam(":informedBy", $informedBy, PDO::PARAM_STR);
    $stmt->bindParam(":permission", $permission, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    $stmt->bindParam(":isAccepted", $isAccepted, PDO::PARAM_INT);
    $stmt->bindParam(":eventRefId", $eventId, PDO::PARAM_INT);

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
    $body = str_replace('{{url}}', CURRENT_URL, $body);

    $this->mailer->send($email, $body, $lang === "Hu" ? "Event regisztráció!" : "Event registration");


    if (isset($_SESSION["subErrors"])) unset($_SESSION["subErrors"]);
    if (isset($_SESSION["prevSubContent"])) unset($_SESSION["prevSubContent"]);

    $this->alert->set("Az eseményre sikeresen regisztráltál!", "You have successfully registered for the event!", null, "success", "/");
  }



  // USER DELETE SELF FROM EVENT WITH MAIL URL
  public function deleteSubscriptionFromMailUrl($id)
  {


    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.registrationId = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $sub = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->prepare("SELECT * FROM `registration_documents`  WHERE registerRefId = :id");
    $stmt->bindParam(":id", $sub["id"], PDO::PARAM_INT);
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (!$sub) {
      $this->alert->set("Ilyen regisztráció nem létezik!", "Registratinon doesn't exist!", null, "danger", "/");
    };

    self::checkIsEventRegistrationExpired(array($sub), 7);


    
    $stmt = $this->pdo->prepare("DELETE FROM `registrations` WHERE `registrationId` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();


    foreach ($documents as $document) {
      unlink("./public/assets/uploads/documents/users/" . $document["name"]);
    }


    $this->alert->set("Esemény regisztráció sikeresen törölve!", "Event subscription deleted succesfully!", null, "success", "/");
  }


  public function acceptUserSubscription($subId)
  {
    $stmt = $this->pdo->prepare("UPDATE `registrations` SET `isAccepted` = '1' WHERE `registrations`.`id` = :subId;");
    $stmt->bindParam(":subId", $subId, PDO::PARAM_INT);
    $stmt->execute();

    $this->alert->set('Eseményre való regisztráció elfogadva!', 'Eseményre való regisztráció elfogadva!', 'Eseményre való regisztráció elfogadva!', "success", "/admin/event/subscriber/$subId");
  }


  public function declineUserSubscription($subId)
  {
    $stmt = $this->pdo->prepare("UPDATE `registrations` SET `isAccepted` = '0' WHERE `registrations`.`id` = :subId;");
    $stmt->bindParam(":subId", $subId, PDO::PARAM_INT);
    $stmt->execute();

    $this->alert->set('Elfogadott regisztráció visszavonva!', 'Elfogadott regisztráció visszavonva!', 'Elfogadott regisztráció visszavonva!', "success", "/admin/event/subscriber/$subId");
  }

  // GET ALL REGISTRATIONS BY EVENT

  public function getSubscriptionsByEvent($eventId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE eventRefId = :id");
    $stmt->bindParam(":id", $eventId, PDO::PARAM_INT);
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

    $stmt->bindParam(":eventRefId", $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $this->pdo->prepare("DELETE FROM `registrations` WHERE `eventRefId` = :eventId");
    $stmt->bindParam(":eventId", $eventId, PDO::PARAM_INT);
    $stmt->execute();

    self::checkIsEventRegistrationExpired($subs, 6);


    header("Location: /user/dashboard");
  }















  public function getSubscriptionsByUser($userId)
  {
    $stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `id` = :id");
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $email = $stmt->fetch(PDO::FETCH_ASSOC)["email"];

    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` 
    INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.email = :email AND registrations.userRefId = :id");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($registrations as $index => $registration) {
      $stmt = $this->pdo->prepare("SELECT * FROM `registration_tasks` WHERE registerRefId = :id");
      $stmt->bindParam(":id", $registration["id"], PDO::PARAM_STR);
      $stmt->execute();
      $registrations[$index]["tasks"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt = $this->pdo->prepare("SELECT * FROM `registration_dates` WHERE registerRefId = :id");
      $stmt->bindParam(":id", $registration["id"], PDO::PARAM_STR);
      $stmt->execute();
      $registrations[$index]["dates"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    return $registrations;
  }





  // GET REGISTERED USER DATA BY ID
  public function getSubbedUserById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM registrations WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $stmt = $this->pdo->prepare("SELECT * FROM registration_dates WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"], PDO::PARAM_INT);
      $stmt->execute();
      $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["dates"] = $dates;

      $stmt = $this->pdo->prepare("SELECT * FROM registration_documents WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"], PDO::PARAM_INT);
      $stmt->execute();
      $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["documents"] = $documents;

      $stmt = $this->pdo->prepare("SELECT * FROM registration_tasks WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"], PDO::PARAM_INT);
      $stmt->execute();
      $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["tasks"] = $tasks;

      $stmt = $this->pdo->prepare("SELECT * FROM registration_languages WHERE registerRefId = :id");
      $stmt->bindParam(":id", $user["id"], PDO::PARAM_INT);
      $stmt->execute();
      $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["langs"] = $tasks;
    }

    return $user;
  }





































  public function addDocumentOfSubscriptions($documentName, $typeOfDocument, $extension, $userRefId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE `registrations`.`userRefId` = :userRefId");
    $stmt->bindParam(':userRefId', $userRefId, PDO::PARAM_INT);
    $stmt->execute();
    $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subs as $sub) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_documents` VALUES (NULL, :name, :type, :extension, :registerRefId);");
      $stmt->bindParam(':name', $documentName, PDO::PARAM_STR);
      $stmt->bindParam(':type', $typeOfDocument, PDO::PARAM_STR);
      $stmt->bindParam(':extension',  $extension, PDO::PARAM_STR);
      $stmt->bindParam(':registerRefId', $sub["id"], PDO::PARAM_INT);

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
    $stmt->bindParam(":documentName", $documentName, PDO::PARAM_STR);
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


      $stmt->bindParam(":name", $documentName, PDO::PARAM_STR);
      $stmt->bindParam(":type", $typeOfDocument, PDO::PARAM_STR);
      $stmt->bindParam(":extension", $extension, PDO::PARAM_STR);
      $stmt->bindParam(":prevImage", $prevImage, PDO::PARAM_STR);
      $stmt->bindParam(":registerRefId", $sub["registerRefId"], PDO::PARAM_INT);
      $stmt->execute();
    }


    self::checkIsEventRegistrationExpired($subs, 4);
  }




  public function checkIsEventRegistrationExpired($subs, $state)
  {
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
        $this->mailer->send("hello@artnesz.hu", $body, "Tájékoztatás");
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
      $stmt->bindParam(":id", $subId, PDO::PARAM_INT);
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
      $stmt->bindParam(':lang', $language["lang"], PDO::PARAM_INT);
      $stmt->bindParam(':level', $language["level"], PDO::PARAM_INT);
      $stmt->bindParam(':registerRefId', $registerId, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  // COPY LANGUAGES FROM REGISTRATIONS TABLE WHEN USER EXIST INTO REGISTRATIONS
  private function copyLanguagesFromUserToSubscribe($registerId, $languages)
  {
    foreach ($languages as $language) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_languages` VALUES (NULL, :lang, :level, :registerRefId);");
      $stmt->bindParam(':lang', $language["lang"], PDO::PARAM_INT);
      $stmt->bindParam(':level', $language["level"], PDO::PARAM_INT);
      $stmt->bindParam(':registerRefId', $registerId);
      $stmt->execute();
    }
  }


  // COPY DOCUMENTS FROM REGISTRATIONS TABLE WHEN USER EXIST INTO REGISTRATIONS
  private function copyDocumentFromUserToSubscribe($registerId, $documents)
  {
    foreach ($documents as $document) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_documents` VALUES (NULL, :name, :type, :extension, :registerRefId);");
      $stmt->bindParam(':name', $document["name"], PDO::PARAM_STR);
      $stmt->bindParam(':type', $document["type"], PDO::PARAM_STR);
      $stmt->bindParam(':extension',  $document["extension"], PDO::PARAM_STR);
      $stmt->bindParam(':registerRefId', $registerId, PDO::PARAM_INT);

      // INSERT parancs végrehajtása
      $stmt->execute();
    }
  }

  // INSERT DATES WHEN USER REGISTER TO EVENT

  private function insertDatesOfSubscription($registerId, $registration_dates)
  {

    foreach ($registration_dates as $date) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_dates` VALUES (NULL, :date, :registerRefId);");
      $stmt->bindParam(':date', $date, PDO::PARAM_STR);
      $stmt->bindParam(':registerRefId', $registerId, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  // INSERT TASKS WHEN USER REGISTER TO EVENT


  private function insertTasksOfSubscription($registerId, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `registration_tasks` VALUES (NULL, :task, :registerRefId);");
      $stmt->bindParam(':task', $task, PDO::PARAM_INT);
      $stmt->bindParam(':registerRefId', $registerId, PDO::PARAM_INT);
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
      $stmt->bindParam(':name', $document["file"], PDO::PARAM_STR);
      $stmt->bindParam(':type', $document["type"], PDO::PARAM_STR);
      $stmt->bindParam(':extension',  $extension, PDO::PARAM_STR);
      $stmt->bindParam(':registerRefId', $registerId, PDO::PARAM_INT);

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
