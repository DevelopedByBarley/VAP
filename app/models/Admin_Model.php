<?php

class AdminModel
{
  protected $pdo;
  protected $fileSaver;
  protected $mailer;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
    $this->mailer = new Mailer();
  }

  public function user($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE `id` LIKE :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

 if ($user) {

      $stmt = $this->pdo->prepare("SELECT * FROM user_documents WHERE userRefId = :id");
      $stmt->bindParam(":id", $user["id"]);
      $stmt->execute();
      $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["documents"] = $documents;


      $stmt = $this->pdo->prepare("SELECT * FROM user_languages WHERE userRefId = :id");
      $stmt->bindParam(":id", $user["id"]);
      $stmt->execute();
      $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $user["langs"] = $tasks;
    }

    return $user;
  }

  public function ban($id) {
    $stmt = $this->pdo->prepare("DELETE FROM users WHERE `id` LIKE :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header('Location: /admin/registrations');
  }


  public function index() {
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

  

  public function admin()
  {
    $adminId = $_SESSION["adminId"] ?? null;

    $stmt = $this->pdo->prepare("SELECT * FROM `admins` WHERE `adminId` = :adminId");
    $stmt->bindParam(":adminId", $adminId);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    return $admin;
  }



}
