<?php

class PartnerModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  // INSERT NEW DOCUMENT FOR ADMIN
  public function insert($files, $body)
  {
    $fileName = $this->fileSaver->saver($files["p_image"], "/uploads/images/partners", null, [
      'image/png',
      'image/jpeg',
    ]);
    
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $link = filter_var($body["link"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `partners` VALUES (NULL, :name, :descriptionInHu, :descriptionInEn, :link, :fileName, :createdAt)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();
    $this->alert->set('Új partner sikeresen hozzáadva!', 'Új partner sikeresen hozzáadva!', 'Partner sikeresen törölve!', "success", "/admin/partners");
  }


  public function partners()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `partners`");
    $stmt->execute();
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $partners;
  }


  // GET ALL OF PARTNERS FOR ADMIN LIST
  public function getPartners()
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM partners");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];


    $offset = $_GET["offset"] ?? 1;
    $limit = 7; // Az oldalanként megjelenített rekordok száma
    $calculated = ($offset - 1) * $limit; // Az OFFSET értékének kiszámítása
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM partners");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása

    $stmt = $this->pdo->prepare("SELECT * FROM `partners` ORDER BY `createdAt` DESC LIMIT $limit OFFSET $calculated");
    $stmt->execute();
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      "partners" => $partners,
      "numOfPage" => $numOfPage,
      "limit" => $limit
    ];
  }


  // DELETE PARTNER FOR ADMIN
  public function delete($id)
  {
    $fileNameForDelete = self::getPartnerById($id)["fileName"];
    unlink("./public/assets/uploads/images/partners/$fileNameForDelete");

    $stmt = $this->pdo->prepare("DELETE FROM `partners` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $this->alert->set('Partner sikeresen törölve!', 'Partner sikeresen törölve!', 'Partner sikeresen törölve!', "success", "/admin/partners");
  }

  public function update($files, $id, $body)
  {
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $link = filter_var($body["link"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $prevImage = self::getPartnerById($id)["fileName"];
    $fileName = '';



    if ($files["p_image"]["name"] !== '') {
      unlink("./public/assets/uploads/images/partners/$prevImage");
      $fileName = $this->fileSaver->saver($files["p_image"], "/uploads/images/partners", null, [
        'image/png',
        'image/jpeg',
      ]);
    } else {
      $fileName = $prevImage;
    }



    $stmt = $this->pdo->prepare("UPDATE `partners` SET 
    `name` = :name, 
    `descriptionInHu` = :descriptionInHu, 
    `descriptionInEn` = :descriptionInEn, 
    `link` = :link, 
    `fileName` = :fileName 
    WHERE `partners`.`id` = :id");

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $this->alert->set('Partner sikeresen frissítve!', 'Partner sikeresen frissítve!', 'Partner sikeresen frissítve!', "success", "/admin/partners");
  }


  // GET PARTNER FOR ADMIN
  public function getPartnerById($id)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `partners` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    return $partner;
  }
}
