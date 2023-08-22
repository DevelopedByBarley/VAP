<?php
class UserEventModel
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

  public function register($body, $eventId, $files)
  {

    echo "<pre>";
    var_dump($body);
    var_dump($files);
    exit;

    $date = $body["dates"] ?? null;
    $tasks = $body["tasks"] ?? null;
    $languages = $body["langs"] ?? [];
    $levels = $body["levels"] ?? [];
  

    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($body["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
    $typeOfDocument = $body["typeOfDocument"] ?? [];

    if(!$date || !$tasks) {
      header("Location: /event/register/" . $eventId);
      exit;
    }

    $stmt = $this->pdo->prepare("INSERT INTO `registrations` (`id`, `name`, `email`, `address`, `mobile`, `profession`, `schoolName`, `otherLanguages`, `isContactAccepted`) 
    VALUES 
    (NULL, :name, :email, :address, :mobile, :profession, :schoolName, :otherLanguages, :isContactAccepted)");
    $stmt->execute();





  }
}
