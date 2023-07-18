<?php

class UserModel
{
  private $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
  }

  public function getMe()
  {
    $userId = $_SESSION["userId"] ?? null;
    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `userId` = :userId");
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  public function update($body)
  {
    $userId = $_SESSION["userId"] ?? null;
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_EMAIL);
    $email = filter_var($body["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $programs = filter_var(PROGRAMS[$body["programs"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $english = filter_var($body["english"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $germany = filter_var($body["germany"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $italy = filter_var($body["italy"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $serbian = filter_var($body["serbian"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $participation = filter_var($body["participation"] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $task = filter_var(TASK_AREAS[$body["tasks"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $informedBy = filter_var(INFORMED_BY[$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);


    $stmt = $this->pdo->prepare("UPDATE `users` 
        SET 
        `name` = :name, 
        `email` = :email,
        `address` = :address,
        `mobile` = :mobile, 
        `profession` = :profession, 
        `schoolName` = :schoolName, 
        `programs` = :programs,
        `english` = :english,
        `germany` = :germany,
        `italy` = :italy,
        `serbian` = :serbian,
        `otherLanguages` = :otherLanguages,
        `participation` = :participation,
        `tasks` = :tasks,
        `informedBy` = :informedBy,
        `permission` = :permission
         WHERE `users`.`userId` = :userId;");

    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':profession', $profession);
    $stmt->bindParam(':schoolName', $school_name);
    $stmt->bindParam(':programs', $programs);
    $stmt->bindParam(':english', $english);
    $stmt->bindParam(':germany', $germany);
    $stmt->bindParam(':italy', $italy);
    $stmt->bindParam(':serbian', $serbian);
    $stmt->bindParam(':otherLanguages', $otherLanguages);
    $stmt->bindParam(':participation', $participation);
    $stmt->bindParam(':tasks', $task);
    $stmt->bindParam(':informedBy', $informedBy);
    $stmt->bindParam(':permission', $permission);

    // INSERT parancs végrehajtása
    $isSuccess = $stmt->execute();

    if ($isSuccess) {
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
    

    if (!$isVerified && !$compared) {
      var_dump("Valami nem ok!");
      exit;
      header('Location: /user/dashboard');
      return;
    }
    
    $stmt = $this->pdo->prepare("UPDATE `users` SET `password` = :password WHERE `users`.`userId` = :userId;");
    $stmt->bindParam(":password", $hashed);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    
    header('Location: /user/dashboard');
  }
}
