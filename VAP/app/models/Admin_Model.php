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
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
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
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $isSuccess = $stmt->execute();

    if ($isSuccess) {
      $this->userModel->deleteUserDocuments($documents);
    }

    header('Location: /admin/registrations');
  }


  public function dashboarData()
  {
    $months = [
      "Jan" => 0,
      "Feb" => 0,
      "Mar" => 0,
      "Apr" => 0,
      "May" => 0,
      "Jun" => 0,
      "Jul" => 0,
      "Aug" => 0,
      "Sep" => 0,
      "Oct" => 0,
      "Nov" => 0,
      "Dec" => 0,
    ];

    $ret = [];
    $countOfUsersWithSubs = 0;
    $countOfUsersWithoutSubs = 0;
    $currentMonthReg = 0;
    $notCurrentMonthReg = 0;

    $stmt = $this->pdo->prepare("SELECT users.*, COUNT(registrations.userRefId) AS registration_count 
    FROM users 
    LEFT JOIN registrations ON users.id = registrations.userRefId 
    GROUP BY users.id");
    $stmt->execute();

    $ret["users"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ret["countOfUsers"] = count($ret["users"]);

    $currentYear = (int)date("Y");
    $currentMonth = date("M");


    $stmt = $this->pdo->prepare("SELECT events.nameInHu, 
    COUNT(registrations.id) AS registrationCount
    FROM events
    LEFT JOIN registrations ON events.eventId = registrations.eventRefId
    LEFT JOIN events AS e ON e.eventId = registrations.eventRefId
    WHERE events.isPublic = 1
    GROUP BY events.nameInHu");
    $stmt->execute();
    $ret["eventSubs"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->prepare("SELECT 
    COUNT(DISTINCT CASE WHEN userRefId IS NULL THEN id END) AS eventRegWithoutProfile
    FROM registrations;");

    $stmt->execute();
    $ret["profileRatio"] = $stmt->fetch(PDO::FETCH_ASSOC);






    foreach ($ret["users"] as $user) {
      (int)$user["registration_count"] > 0 ? $countOfUsersWithSubs += 1 : '';
      (int)$user["registration_count"] === 0 ? $countOfUsersWithoutSubs += 1 : '';

      if (date("M", $user["createdAt"]) === $currentMonth && (int)date("Y", $user["createdAt"]) === $currentYear) {
        $currentMonthReg += 1;
      } else {
        $notCurrentMonthReg += 1;
      }

      foreach ($months as $month => $counter) {
        if (date("M", $user["createdAt"]) === $month && (int)date("Y", $user["createdAt"]) === $currentYear) {
          $months[$month] += 1;
        }
      }
    }

    $ret["months"] = $months;
    $ret["userWithSub"] = $countOfUsersWithSubs;
    $ret["userWithoutSub"] = $countOfUsersWithoutSubs;
    $ret["currentMonthReg"] = $currentMonthReg;
    $ret["notCurrentMonthReg"] = $notCurrentMonthReg;



    return $ret;
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
    $stmt->bindParam(":searched", $searched, PDO::PARAM_STR);
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása


    $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `name` LIKE :searched LIMIT $limit OFFSET $calculated");
    $stmt->bindParam(":searched", $searched, PDO::PARAM_STR);
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
    $stmt->bindParam(":adminId", $adminId, PDO::PARAM_STR);
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
