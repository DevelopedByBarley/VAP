<?php

class UserModel
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

  public function getMe()
  {
    $userId = $_SESSION["userId"] ?? null;
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  public function registerUser($files, $body)
  {

    $fileName = $this->fileSaver->saver($files["file"], "/uploads/images/users", null);
    $documentName = $this->fileSaver->saver($files["documents"], "/uploads/documents/users", null);

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
    $task = filter_var(TASK_AREAS["areas"][$body["tasks"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $informedBy = filter_var(INFORMED_BY["inform"][$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
    $typeOfDocument = $body["typeOfDocument"] ?? [];
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];

    $documents = self::formatDocuments($documentName, $typeOfDocument);


    $createdAt = time();






    $isUserExist = self::checkIsUserExist($email);

    if ($isUserExist) {
      echo "User exist";
      exit;
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
        :tasks, 
        :informedBy, 
        :permission, 
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
    $stmt->bindParam(':tasks', $task);
    $stmt->bindParam(':informedBy', $informedBy);
    $stmt->bindParam(':permission', $permission);
    $stmt->bindParam(':fileName', $fileName);
    $stmt->bindParam(':createdAt', $createdAt);

    // INSERT parancs végrehajtása
    $stmt->execute();

    $lastInsertedId = $this->pdo->lastInsertId();

    if ($lastInsertedId) {
      self::insertDocuments($lastInsertedId, $documents);
      self::insertLanguages($lastInsertedId, $languages, $levels);
      $this->mailer->send($email, "Köszönjük a profil regisztrációt!", "Profil regisztráció!");
      header("Location: /");
    }

  }

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
    $task = filter_var(TASK_AREAS["areas"][$body["tasks"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $informedBy = filter_var(INFORMED_BY["inform"][$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];

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
        `tasks` = :tasks,
        `informedBy` = :informedBy,
        `permission` = :permission
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
    $stmt->bindParam(':tasks', $task);
    $stmt->bindParam(':informedBy', $informedBy);
    $stmt->bindParam(':permission', $permission);

    // INSERT parancs végrehajtása
    $isSuccess = $stmt->execute();

    if ($isSuccess) {
      self::updateUserLanguages($userId, $languages, $levels);
      header('Location: /user/dashboard');
    }
  }


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
      $_SESSION["alert"] = [
        "message" => "Jelszó megváltoztatása sikertelen, ön hibás adatokat adott meg!",
        "bg" => "red"
      ];
      header('Location: /user/password-reset');
      return;
    }

    $stmt = $this->pdo->prepare("UPDATE `users` SET `password` = :password WHERE `users`.`userId` = :userId;");
    $stmt->bindParam(":password", $hashed);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    $_SESSION["alert"] = [
      "message" => "Jelszó megváltoztatása sikeres!",
      "bg" => "green"
    ];
    header('Location: /user/dashboard');
  }

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


          foreach ($documents as $document) {
            $documentName = $document["name"];
            unlink("./public/assets/uploads/documents/users/$documentName");
          }

          header("Location: /");
        }
      }
    }
  }

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

  public function addDocument($files, $body)
  {
    $userRefId = $_SESSION["userId"] ?? null;
    $fileName = $this->fileSaver->saver($files["document"], "/uploads/documents/users", null);
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

  public function updateDocument($id, $files, $body)
  {
    $typeOfDocument = filter_var((int)$body["typeOfDocument"] ?? '', FILTER_SANITIZE_NUMBER_INT);

    $prevImage = $this->getDocumentById($id)["name"];
    $fileName = '';
    if ($files["document"]["name"] !== '') {
      $fileName = $this->fileSaver->saver($files["document"], "/uploads/documents/users", $prevImage);
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

  private function updateUserLanguages($id, $languages, $levels)
  {
    $stmt = $this->pdo->prepare("DELETE FROM `user_languages` where `userRefId` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    self::insertLanguages($id, $languages, $levels);
  }


  public function getDocumentsByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_documents` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $documents;
  }

  public function getDocumentById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_documents` WHERE `id` = :id");

    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $document = $stmt->fetch(PDO::FETCH_ASSOC);

    return $document;
  }

  public function getLanguagesByUser($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `user_languages` WHERE `userRefId` = :id");

    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $languages;
  }

  public function getRegistrationsByUser($userId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `registrations` INNER JOIN events ON registrations.eventRefId = events.eventId WHERE registrations.userRefId = :id");

    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $registrations;
  }


}
