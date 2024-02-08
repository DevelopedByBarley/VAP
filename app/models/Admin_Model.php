<?php

require_once 'app/models/User_Model.php';
require_once 'app/helpers/Alert.php';

class AdminModel
{
  protected $pdo;
  protected $fileSaver;
  protected $mailer;
  private $userModel;
  protected $alert;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
    $this->userModel = new UserModel();
    $this->alert = new Alert();
  }

  // GET USER BY SESSION

  public function user($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE `id` LIKE :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $documents = $this->userModel->getDocumentsByUser($user["id"]);
      $langs = $this->userModel->getLanguagesByUser($user["id"]);

      $user["documents"] = $documents;
      $user["langs"] = $langs;
    }

    return $user;
  }


  // BAN REGISTERED USER
  public function ban($id)
  {
    $documents = self::user($id)["documents"];
    $fileNameForDelete = self::user($id)["fileName"];

  
    unlink("./public/assets/uploads/images/users/$fileNameForDelete");


    $stmt = $this->pdo->prepare("DELETE FROM users WHERE `id` LIKE :id");
    $stmt->bindParam(":id", $id);
    $isSuccess = $stmt->execute();

    if ($isSuccess) {
      $this->userModel->deleteUserDocuments($documents);
    }

    header('Location: /admin/registrations');
  }




  // GET ALL OF REGISTERED PROFILES
  public function index()
  {
    $offset = $_GET["offset"] ?? 1;
    $limit = 10; // Az oldalanként megjelenített rekordok száma
    $calculated = ($offset - 1) * $limit; // Az OFFSET értékének kiszámítása
    $name = $_GET["search"] ?? '';
    $searched = "%" . $name . "%";

    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE `name` LIKE :searched");
    $stmt->bindParam(":searched", $searched);
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása


    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `name` LIKE :searched LIMIT $limit OFFSET $calculated");
    $stmt->bindParam(":searched", $searched);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      "users" => $users,
      "numOfPage" => $numOfPage,
      "limit" => $limit
    ];
  }



  //"GET ADMIN BY SESSION"
  public function admin()
  {
    $adminId = $_SESSION["adminId"] ?? null;

    $stmt = $this->pdo->prepare("SELECT * FROM `admins` WHERE `adminId` = :adminId");
    $stmt->bindParam(":adminId", $adminId);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    return $admin;
  }


  public function sendMailToUser($body, $userId)
  {

    $user = self::user($userId);




    $this->mailer->send($user["email"], $body["mail-body"], $user["lang"] === "Hu" ? "Üzenet" : "Message");

    $this->alert->set('Sikeres email kiküldés!', 'Sikeres email kiküldés!', 'Sikeres email kiküldés!', 'success', "/admin/user/$userId");
  }
}
