<?php
require_once 'app/helpers/Alert.php';
require_once 'app/services/AuthService.php';


class UserModel
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

  // GET USER BY SESSION
  public function getMe()
  {
    $userId = $_SESSION["userId"] ?? null;
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }


  // REGISTER USER 
  public function registerUser($files, $body)
  {
    $fileName = $this->fileSaver->saver($files["file"], "/uploads/images/users", null, [
      'image/png',
      'image/jpeg',
    ]);
    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null, null);


    if (!$fileName || in_array(false, $documentName)) {
      self::setPrevContent();

      $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/user/registration");
    }

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
    $typeOfDocument = $body["typeOfDocument"] ?? [];
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];

    $documents = self::formatDocuments($documentName, $typeOfDocument);


    $lang = $_COOKIE["lang"] ?? null;
    $createdAt = time();







    $isUserExist = self::checkIsUserExist($email);

    if ($isUserExist) {
      self::setPrevContent();
      $this->alert->set(
        "Ez a felhasználó már létezik!",
        "This user is already exist!",
        null,
        "danger",
        "/user/registration"
      );
    }




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
        :createdAt)");

    // Paraméterek kötése
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pw);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':profession', $profession);
    $stmt->bindParam(':schoolName', $school_name);
    $stmt->bindParam(':programs', $programs);
    $stmt->bindParam(':otherLanguages', $otherLanguages);
    $stmt->bindParam(':participation', $participation);
    $stmt->bindParam(':informedBy', $informedBy);
    $stmt->bindParam(':permission', $permission);
    $stmt->bindParam(':lang', $lang);
    $stmt->bindParam(':fileName', $fileName);
    $stmt->bindParam(':createdAt', $createdAt);

    // INSERT parancs végrehajtása
    $stmt->execute();

    $lastInsertedId = $this->pdo->lastInsertId();

    if ($lastInsertedId) {
      self::insertDocuments($lastInsertedId, $documents);
      self::insertLanguages($lastInsertedId, $languages, $levels);
      self::insertTasks($lastInsertedId, $tasks);
      $body = file_get_contents("./app/views/templates/user_registration/UserRegistrationMailTemplate" . $lang . ".php");
      $body = str_replace('{{name}}', $name, $body);

      $this->mailer->send($email, $body, $lang === "Hu" ? "Profil regisztráció" : "Profile registration");

      if (isset($_SESSION["prevRegisterContent"])) unset($_SESSION["prevRegisterContent"]);

      success();
    }
  }


  // UPDATE USER FROM USER SETTINGS
  public function update($body)
  {
    $userId = $_SESSION["userId"] ?? null;
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

    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':profession', $profession);
    $stmt->bindParam(':schoolName', $school_name);
    $stmt->bindParam(':programs', $programs);
    $stmt->bindParam(':otherLanguages', $otherLanguages);
    $stmt->bindParam(':participation', $participation);
    $stmt->bindParam(':informedBy', $informedBy);
    $stmt->bindParam(':permission', $permission);
    $stmt->bindParam(':lang', $lang);

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
    $userName = self::getMe()["name"];
    $idForDelete = $body["idForDelete"] ?? null;
    $documents = self::getDocumentsByUser($userId);

    if ("Delete" . "_" . $userName === $idForDelete) {

      $fileNameForDelete = self::getMe($userId)["fileName"];
      unlink("./public/assets/uploads/images/users/$fileNameForDelete");

      $stmt = $this->pdo->prepare("DELETE FROM `users` where `id` = :id");
      $stmt->bindParam(":id", $userId);
      $isSuccess = $stmt->execute();



      if ($isSuccess) {

        $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        if ($isSuccess) {
          self::deleteUserLanguages($userId);
          self::deleteUserDocuments($documents);
        }
      }
    }
  }

  // DELETE ALL LANGUAGES BY USER
  public function deleteUserLanguages($userId)
  {

    $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
  }





















  // DOCUMENTS -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*>

  // DELETE SINGLE DOCUMENT FROM USER SETTINGS

  public function deleteDocument($id)
  {
    $documentName = self::getDocumentById($id)["name"];

    if ($documentName) {
      unlink("./public/assets/uploads/documents/users/$documentName");
    }

    $stmt = $this->pdo->prepare("DELETE FROM `user_documents` where `id` = :id");
    $stmt->bindParam(":id", $id);
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
    $typeOfDocument = filter_var((int)$body["typeOfDocument"] ?? '', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $this->pdo->prepare("INSERT INTO `user_documents` (`id`, `name`, `type`, `extension`, `userRefId`) VALUES (NULL, :name, :type, :extension, :userRefId);");
    $extension =  pathinfo($fileName, PATHINFO_EXTENSION);
    // Paraméterek kötése
    $stmt->bindParam(':name', $fileName);
    $stmt->bindParam(':type', $typeOfDocument);
    $stmt->bindParam(':extension',  $extension);
    $stmt->bindParam(':userRefId', $userRefId);

    $isSuccesS = $stmt->execute();

    if ($isSuccesS) {
      header("Location: /user/documents");
    }
  }

  // UPDATE DOCUMENT FROM USER SETTINGS
  public function updateDocument($id, $files, $body)
  {
    $typeOfDocument = filter_var((int)$body["typeOfDocument"] ?? '', FILTER_SANITIZE_NUMBER_INT);

    //$prevImage = $this->getDocumentById($id)["name"];
    $prevImage = self::getDocumentById($id)["name"];
    $fileName = '';
    if ($files["document"]["name"] !== '') {
      $fileName = $this->fileSaver->saver($files["document"], "/uploads/documents/users", $prevImage, null);
    } else {
      $fileName = $prevImage;
    }

    $extension =  pathinfo($fileName, PATHINFO_EXTENSION);



    $stmt = $this->pdo->prepare("UPDATE `user_documents` SET 
    `name` = :name, 
    `type` = :type, 
    `extension` = :extension 
    WHERE `user_documents`.`id` = :id");

    $stmt->bindParam(":name", $fileName);
    $stmt->bindParam(":type", $typeOfDocument);
    $stmt->bindParam(":extension", $extension);
    $stmt->bindParam(":id", $id);

    $isSuccess = $stmt->execute();

    if ($isSuccess) header("Location: /user/documents");
  }

  // GET DOCUMENTS BY USER ID

  public function getDocumentsByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_documents` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $documents;
  }

  // GET SINGLE DOCUMENT BY USER ID

  public function getDocumentById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_documents` WHERE `id` = :id");

    $stmt->bindParam(":id", $id);
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
      $stmt->bindParam(':name', $document["file"]);
      $stmt->bindParam(':type', $document["type"]);
      $stmt->bindParam(':extension',  $extension);
      $stmt->bindParam(':userRefId', $id);

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
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertTasks($id, $tasks);
  }

  private function insertTasks($id, $tasks)
  {
    foreach ($tasks as $task) {
      $stmt = $this->pdo->prepare("INSERT INTO `user_tasks` VALUES (NULL, :task, :userRefId)");
      $stmt->bindParam(':task', $task);
      $stmt->bindParam(':userRefId', $id);
      $stmt->execute();
    }
  }

  public function getTasksByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_tasks` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tasks;
  }



  // LANGUAGES

  // GET LANGUAGES BY USER ID

  public function getLanguagesByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_languages` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id);
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
      $stmt->bindParam(':lang', $language["lang"]);
      $stmt->bindParam(':level', $language["level"]);
      $stmt->bindParam(':userRefId', $id);
      $stmt->execute();
    }
  }


  // UPDATE LANGUAGES
  private function updateUserLanguages($id, $languages, $levels)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
    $stmt->bindParam(":id", $id);
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
        "Jelszó megváltoztatása sikertelen, ön hibás adatokat adott meg!",
        "Password change unsuccessful, you provided incorrect data!",
        null,
        "danger",
        "/user/password-reset"
      );
    }

    $stmt = $this->pdo->prepare("UPDATE `users` SET `password` = :password WHERE `users`.`id` = :userId;");
    $stmt->bindParam(":password", $hashed);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();

    $this->alert->set(
      "Jelszó megváltoztatása sikeres!",
      "Password change successful!",
      null,
      "success",
      "/user/dashboard"
    );
  }





  /**SUBSCRIBER??????? --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

  // GET ALL EVENT DATA BY SUBSCRIBER

  public function getRegistrationsByUser($userId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.userRefId = :id");

    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $registrations;
  }


  /**PRIVATES ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ */

  // CHECK USER EMAIL EXIST INTO THE DB 
  private function checkIsUserExist($email)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");

    $stmt->bindParam(":email", $email);
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
    $_SESSION["prevRegisterContent"] = $_POST;
  }
}
