<?php
require_once 'app/helpers/Alert.php';
require_once 'app/services/AuthService.php';
require_once 'app/helpers/Validate.php';
require_once 'app/models/Subscription_Model.php';


class UserModel
{
  private $pdo;
  private $fileSaver;
  private $mailer;
  private $alert;
  private $subModel;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
    $this->alert = new Alert();
    $this->subModel = new Subscription_Model();
  }

  // GET USER BY SESSION
  public function getMe()
  {
    $userId = $_SESSION["userId"] ?? null;
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }



  // REGISTER USER 
  public function registerUser($files, $body)
  {


    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($body["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $pw = password_hash(filter_var($body["password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT);
    $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $programs = filter_var(PROGRAMS["program"][$body["programs"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $participation = filter_var($body["participation"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $tasks = $body["tasks"] ?? null;
    $informedBy = filter_var(INFORMED_BY["inform"][$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);

    $code = uniqid();
    $isActivated = 0;
    $expires = time() + 600;

    $typeOfDocument = $body["typeOfDocument"] ?? [];
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];




    $lang = $_COOKIE["lang"] ?? null;
    $createdAt = time();



    $isUserExist = self::checkIsUserExist($email);

    if ($isUserExist) {
      self::setPrevContent();
      $this->alert->set(
        "Valami probléma merült fel a regisztrációval, kérünk jelentkezz be vagy próbálkozz más adatokkal!",
        "There was a problem with the registration, please log in or try using other data!",
        null,
        "danger",
        "/user/registration"
      );
    }




    $fileName = $this->fileSaver->saver($files["file"], "/uploads/images/users", null, [
      'image/png',
      'image/jpeg',
    ]);

    if (!$fileName) {
      self::setPrevContent();
      $this->alert->set("Feltöltött fénykép file típus elutasítva", "Uploaded profile picture file type rejected!", null, "danger", "/user/registration");
    }


    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null, null);


    

    if (in_array(false, $documentName)) {
      self::setPrevContent();
      $this->fileSaver->deleteDeclinedFiles($documentName);
      unlink("./public/assets/uploads/images/users/$fileName");


      $this->alert->set("Feltöltött dokumentum file típus elutasítva", "Uploaded document file type rejected", null, "danger", "/user/registration");
    }

    $documents = self::formatDocuments($documentName, $typeOfDocument);



    // INSERT parancs előkészítése
    $stmt = $this->pdo->prepare("INSERT INTO users VALUES 
        (NULL, 
        :name, 
        :email, 
        :password, 
        :address, 
        :mobile, 
        :profession, 
        :schoolName, 
        :programs,  
        :otherLanguages, 
        :participation, 
        :informedBy, 
        :permission, 
        :lang, 
        :fileName,
        :createdAt,
        :activation_code,
        :expires,
        :isActivated
        )");

    // Paraméterek kötése
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pw, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $stmt->bindParam(':profession', $profession, PDO::PARAM_STR);
    $stmt->bindParam(':schoolName', $school_name, PDO::PARAM_STR);
    $stmt->bindParam(':programs', $programs, PDO::PARAM_STR);
    $stmt->bindParam(':otherLanguages', $otherLanguages, PDO::PARAM_STR);
    $stmt->bindParam(':participation', $participation, PDO::PARAM_INT);
    $stmt->bindParam(':informedBy', $informedBy, PDO::PARAM_STR);
    $stmt->bindParam(':permission', $permission, PDO::PARAM_INT);
    $stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
    $stmt->bindParam(':fileName', $fileName, PDO::PARAM_STR);
    $stmt->bindParam(':createdAt', $createdAt, PDO::PARAM_INT);
    $stmt->bindParam(':activation_code', $code, PDO::PARAM_STR);
    $stmt->bindParam(':expires', $expires, PDO::PARAM_INT);
    $stmt->bindParam(':isActivated', $isActivated, PDO::PARAM_INT);

    // INSERT parancs végrehajtása
    $stmt->execute();

    $lastInsertedId = $this->pdo->lastInsertId();

    if ($lastInsertedId) {
      self::insertDocuments($lastInsertedId, $documents);
      self::insertLanguages($lastInsertedId, $languages, $levels);
      self::insertTasks($lastInsertedId, $tasks);
      $body = file_get_contents("./app/views/templates/user_registration/UserRegistrationMailTemplate" . $lang . ".php");
      $body = str_replace('{{name}}', $name, $body);
      $body = str_replace('{{code}}', $code, $body);
      $body = str_replace('{{url}}', CURRENT_URL, $body);


      $this->mailer->send($email, $body, $lang === "Hu" ? "Profil regisztráció" : "Profile registration");

      if (isset($_SESSION["prevRegContent"])) unset($_SESSION["prevRegContent"]);

      $this->alert->set("Sikeres regisztráció! Az ön e-mail címére visszaigazoló e-mailt küldtünk!", "Successful registration! We have sent a confirmation email to your email address!", null, "success", "/login");
    }
  }


  // UPDATE USER FROM USER SETTINGS
  public function update($body)
  {

    $userId = $_SESSION["userId"] ?? null;
    $this->subModel->updateUserDataOfSubscription($body, $userId);
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $programs = filter_var(PROGRAMS["program"][$body["programs"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $participation = filter_var($body["participation"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $tasks = $body["tasks"] ?? null;
    $informedBy = filter_var(INFORMED_BY["inform"][$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];

    $lang = $_COOKIE["lang"] ?? null;



    $stmt = $this->pdo->prepare("UPDATE `users` 
        SET 
        `name` = :name, 
        `address` = :address,
        `mobile` = :mobile, 
        `profession` = :profession, 
        `schoolName` = :schoolName, 
        `programs` = :programs,
        `otherLanguages` = :otherLanguages,
        `participation` = :participation,
        `informedBy` = :informedBy,
        `permission` = :permission,
        `lang` = :lang
         WHERE `users`.`id` = :userId;");

    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $stmt->bindParam(':profession', $profession, PDO::PARAM_STR);
    $stmt->bindParam(':schoolName', $school_name, PDO::PARAM_STR);
    $stmt->bindParam(':programs', $programs, PDO::PARAM_STR);
    $stmt->bindParam(':otherLanguages', $otherLanguages, PDO::PARAM_STR);
    $stmt->bindParam(':participation', $participation, PDO::PARAM_INT);
    $stmt->bindParam(':informedBy', $informedBy, PDO::PARAM_STR);
    $stmt->bindParam(':permission', $permission, PDO::PARAM_INT);
    $stmt->bindParam(':lang', $lang, PDO::PARAM_STR);

    // INSERT parancs végrehajtása
    $isSuccess = $stmt->execute();

    if ($isSuccess) {
      self::updateUserLanguages($userId, $languages, $levels);
      self::updateTasks($userId, $tasks);

      $this->alert->set('Profil frissítése sikeres!', 'You updating your profile successfully!', null, 'success', '/user/settings');
    }
  }

  // USER DELETE SELF

  public function delete($body)
  {
    $userId = $_SESSION["userId"] ?? null;
    $this->subModel->userDeleteSubsAndSelf($userId);
    $userName = self::getMe()["name"];
    $idForDelete = $body["idForDelete"] ?? null;
    $documents = self::getDocumentsByUser($userId);

    if ("Delete" . "_" . $userName === $idForDelete) {

      $fileNameForDelete = self::getMe($userId)["fileName"];
      unlink("./public/assets/uploads/images/users/$fileNameForDelete");

      $stmt = $this->pdo->prepare("DELETE FROM `users` where `id` = :id");
      $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
      $isSuccess = $stmt->execute();



      if ($isSuccess) {

        self::deleteUserLanguages($userId);
        self::deleteUserDocuments($documents);

        $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();
      }
    }
  }

  // DELETE ALL LANGUAGES BY USER
  public function deleteUserLanguages($userId)
  {

    $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
  }




























  public function activateRegister()
  {
    $code = filter_var($_GET["code"] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$code) {
      header('Location: /');
    }

    try {
      // Ellenőrizze, hogy van-e olyan rekord, amelynek az isActivated értéke 0, és az activation_code megegyezik a kóddal
      $checkStmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `isActivated` = 0 AND `activation_code` = :activation_code");
      $checkStmt->bindValue(':activation_code', $code, PDO::PARAM_STR);
      $checkStmt->execute();

      $user = $checkStmt->fetch(PDO::FETCH_ASSOC);



      $isExpired = $user["expires"] < time();

      if ($isExpired) {
        $this->alert->set("Regisztráció aktiválása sikertelen! Lejárt link!", "Registration error! Link expired!", null, "danger", "/login");
      }

      $rowCount = $checkStmt->rowCount();

      if ($rowCount > 0) {
        // Van ilyen rekord, tehát folytathatja az aktiválást
        $updateStmt = $this->pdo->prepare("UPDATE `users` SET `isActivated` = '1', `activation_code` = NULL WHERE `isActivated` = 0 AND `activation_code` = :activation_code");
        $updateStmt->bindValue(':activation_code', $code, PDO::PARAM_STR);
        $updateStmt->execute();

        // Sikeres aktiválás üzenet beállítása
        $this->alert->set("Regisztráció sikeresen aktiválva!", "Registration is successfully activated!", null, "success", "/login");
      } else {
        // Nincs ilyen rekord, így hibát jelenthet
        $this->alert->set("Hiba a regisztráció aktiválása közben!", "Error while activating the registration!", null, "danger", "/");
      }
    } catch (PDOException $e) {
      // Hiba kezelése
      $this->alert->set("Hiba történt az aktiválás során.", "Error occurred during activation.", null, "danger", "/");
      error_log("Aktiválási hiba: " . $e->getMessage());
    }
  }


  public function deleteExpiredRegistrations()
  {
    $now = time();
    $stmt = $this->pdo->prepare("SELECT id, fileName FROM `users` WHERE expires < :currentTime AND isActivated = 0");
    $stmt->bindParam(":currentTime", $now, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (!empty($users)) {
      foreach ($users as $user) {
        $documents = self::getDocumentsByUser($user["id"]);
        self::deleteUserLanguages($user["id"]);
        unlink("./public/assets/uploads/images/users/" . $user["fileName"]);
      }

      // Ha a $documents üres, akkor ne próbáljuk törölni
      if (!empty($documents)) {
        self::deleteUserDocuments($documents);
      }

      // A DELETE lekérdezéshez hozzá kell adni az "FROM" kulcsszót
      $stmt = $this->pdo->prepare("DELETE FROM `users` WHERE expires <= :currentTime AND isActivated = 0");
      $stmt->bindParam(":currentTime", $now, PDO::PARAM_INT);
      $stmt->execute();
    }
  }


  public function deleteExpiresPasswordResetTokens()
  {
    $now = date('Y-m-d H:i:s');
    $stmt = $this->pdo->prepare("DELETE FROM `password_reset_tokens` WHERE expires < :currentTime");
    $stmt->bindParam(":currentTime", $now, PDO::PARAM_STR);
    $stmt->execute();
  }




















































  // DOCUMENTS -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*>

  // DELETE SINGLE DOCUMENT FROM USER SETTINGS

  public function deleteDocument($id)
  {
    $documentName = self::getDocumentById($id)["name"];
    $this->subModel->deleteDocumentOfSubscription($documentName);

    if ($documentName) {
      unlink("./public/assets/uploads/documents/users/$documentName");
    }

    $stmt = $this->pdo->prepare("DELETE FROM `user_documents` where `id` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $isSuccess = $stmt->execute();


    if ($isSuccess) {
      header("Location: /user/documents");
    }
  }

  // DELETE ALL DOCUMENTS BY USER
  public function deleteUserDocuments($documents)
  {

    foreach ($documents as $document) {
      $documentName = $document["name"];
      unlink("./public/assets/uploads/documents/users/$documentName");
    }
  }

  // ADD DOCUMENT FROM USER SETTINGS
  public function addDocument($files, $body)
  {
    $userRefId = $_SESSION["userId"] ?? null;
    $fileName = $this->fileSaver->saver($files["document"], "/uploads/documents/users", null, null);
    if (!$fileName) {
      $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/user/documents/new");
    }

    $typeOfDocument = filter_var((int)$body["typeOfDocument"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $extension =  pathinfo($fileName, PATHINFO_EXTENSION);
    $this->subModel->addDocumentOfSubscriptions($fileName, $typeOfDocument, $extension, $userRefId);

    $stmt = $this->pdo->prepare("INSERT INTO `user_documents` (`id`, `name`, `type`, `extension`, `userRefId`) VALUES (NULL, :name, :type, :extension, :userRefId);");


    // Paraméterek kötése
    $stmt->bindParam(':name', $fileName, PDO::PARAM_STR);
    $stmt->bindParam(':type', $typeOfDocument, PDO::PARAM_STR);
    $stmt->bindParam(':extension',  $extension, PDO::PARAM_STR);
    $stmt->bindParam(':userRefId', $userRefId, PDO::PARAM_INT);

    $isSuccesS = $stmt->execute();



    if ($isSuccesS) {

      $this->alert->set("Dokumentum sikeresen hozzáadva!", "Document added successfully!", null, "success", "/user/documents");
    }
  }

  // UPDATE DOCUMENT FROM USER SETTINGS
  public function updateDocument($id, $files, $body)
  {
    $userId = $_SESSION["userId"];
    $typeOfDocument = filter_var((int)$body["typeOfDocument"] ?? '', FILTER_SANITIZE_NUMBER_INT);

    $prevImage = self::getDocumentById($id)["name"];
    $fileName = '';
    if ($files["document"]["name"] !== '') {
      $fileName = $this->fileSaver->saver($files["document"], "/uploads/documents/users", $prevImage, null);
    } else {
      $fileName = $prevImage;
    }
    $extension =  pathinfo($fileName, PATHINFO_EXTENSION);

    if (!$fileName) {
      $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/user/documents/update/" . $id);
    }

    $stmt = $this->pdo->prepare("UPDATE `user_documents` SET 
    `name` = :name, 
    `type` = :type, 
    `extension` = :extension 
    WHERE `user_documents`.`id` = :id");

    $stmt->bindParam(":name", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":type", $typeOfDocument, PDO::PARAM_STR);
    $stmt->bindParam(":extension", $extension, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    $isSuccess = $stmt->execute();

    if ($isSuccess) {
      $this->subModel->updateSubDocument($prevImage, $fileName, $typeOfDocument, $extension, $userId);
      $this->alert->set("Dokumentum sikeresen frissítve!", "Document updated successfully!", null, "success", "/user/documents");
    };
  }

  // GET DOCUMENTS BY USER ID

  public function getDocumentsByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_documents` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $documents;
  }

  // GET SINGLE DOCUMENT BY USER ID

  public function getDocumentById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_documents` WHERE `id` = :id");

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $document = $stmt->fetch(PDO::FETCH_ASSOC);

    return $document;
  }

  // INSERT DOCUMENT ON USER REGISTRATION!
  private function insertDocuments($id, $documents)
  {
    foreach ($documents as $document) {
      $stmt = $this->pdo->prepare("INSERT INTO `user_documents` (`id`, `name`, `type`, `extension`, `userRefId`) VALUES (NULL, :name, :type, :extension, :userRefId);");
      $extension =  pathinfo($document["file"], PATHINFO_EXTENSION);
      // Paraméterek kötése
      $stmt->bindParam(':name', $document["file"], PDO::PARAM_STR);
      $stmt->bindParam(':type', $document["type"], PDO::PARAM_STR);
      $stmt->bindParam(':extension',  $extension, PDO::PARAM_STR);
      $stmt->bindParam(':userRefId', $id, PDO::PARAM_INT);

      // INSERT parancs végrehajtása
      $stmt->execute();
    }
  }

  // FORMAT DOCUMENTS FOR INSERT INTO THE DB
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





  // TASKS

  private function updateTasks($id, $tasks)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `user_tasks` where `userRefId` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    self::insertTasks($id, $tasks);
  }

  private function insertTasks($id, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `user_tasks` VALUES (NULL, :task, :userRefId)");
      $stmt->bindParam(':task', $task, PDO::PARAM_INT);
      $stmt->bindParam(':userRefId', $id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  public function getTasksByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_tasks` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tasks;
  }



  // LANGUAGES

  // GET LANGUAGES BY USER ID

  public function getLanguagesByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_languages` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $languages;
  }

  // INSERT LANGUAGES

  private function insertLanguages($id, $languages, $levels)
  {
    $ret = [];

    for ($i = 0; $i < count($languages); $i++) {
      $ret[$i] = [
        "lang" => $languages[$i],
        "level" => $levels[$i]
      ];
    }


    foreach ($ret as $language) {
      $stmt = $this->pdo->prepare("INSERT INTO `user_languages` (`id`, `lang`, `level`, `userRefId`) VALUES (NULL, :lang, :level, :userRefId);");
      $stmt->bindParam(':lang', $language["lang"], PDO::PARAM_INT);
      $stmt->bindParam(':level', $language["level"], PDO::PARAM_INT);
      $stmt->bindParam(':userRefId', $id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }


  // UPDATE LANGUAGES
  private function updateUserLanguages($id, $languages, $levels)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    self::insertLanguages($id, $languages, $levels);
  }



  // RESET PW FROM USER SETTINGS PAGE

  public function resetPw($body)
  {
    $userId = $_SESSION["userId"] ?? null;

    $old_pw = filter_var($body["old_password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $new_pw = filter_var($body["new_password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_pw = filter_var($body["confirm_password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $hashed = password_hash($new_pw, PASSWORD_DEFAULT);
    $user = self::getMe();

    $isVerified = password_verify($old_pw, $user["password"]);
    $compared = $confirm_pw === $new_pw;

    if (!$isVerified || !$compared) {
      $this->alert->set(
        "Jelszó megváltoztatása sikertelen, bizonyosodj meg róla hogy helyes adatokat adtál meg!",
        "Password change unsuccessful, you provided incorrect data!",
        null,
        "danger",
        "/user/password-reset"
      );
    }

    $stmt = $this->pdo->prepare("UPDATE `users` SET `password` = :password WHERE `users`.`id` = :userId;");
    $stmt->bindParam(":password", $hashed, PDO::PARAM_STR);
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->execute();

    $this->alert->set(
      "Jelszó megváltoztatása sikeres!",
      "Password change successful!",
      null,
      "success",
      "/user/dashboard"
    );
  }




  /**PRIVATES ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ */

  // CHECK USER EMAIL EXIST INTO THE DB 
  private function checkIsUserExist($email)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");

    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user)) {
      return true;
    }

    return false;
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
    $_SESSION["prevRegContent"] = $_POST;
  }
}
