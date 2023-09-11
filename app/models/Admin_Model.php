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
