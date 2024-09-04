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

    if (!$fileName) {
      $this->alert->set("File típus elutasítva", "File típus elutasítva", null, "danger", "/admin/partners/new");
    }
    
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $link = filter_var($body["link"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_var($body["type"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `partners` VALUES (NULL, :name, :descriptionInHu, :descriptionInEn, :link, :type, :fileName, :createdAt)");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn, PDO::PARAM_STR);
    $stmt->bindParam(":link", $link, PDO::PARAM_STR);
    $stmt->bindParam(":type", $type, PDO::PARAM_STR);
    $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":createdAt", $createdAt, PDO::PARAM_INT);

    $stmt->execute();
    $this->alert->set('Új partner sikeresen hozzáadva!', 'Új partner sikeresen hozzáadva!', 'Partner sikeresen hozzáadva!', "success", "/admin/partners");
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
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $this->alert->set('Partner sikeresen törölve!', 'Partner sikeresen törölve!', 'Partner sikeresen törölve!', "success", "/admin/partners");
  }

  public function update($files, $id, $body)
  {
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $link = filter_var($body["link"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_var($body["type"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $prevImage = self::getPartnerById($id)["fileName"];
    $fileName = '';



    if ($files["p_image"]["name"] !== '') {
      $fileName = $this->fileSaver->saver($files["p_image"], "/uploads/images/partners", null, [
        'image/png',
        'image/jpeg',
      ]);
      if (!$fileName) {
        $this->alert->set("File típus elutasítva", "File típus elutasítva", null, "danger", "/admin/partners/update/" . $id);
      }
      unlink("./public/assets/uploads/images/partners/$prevImage");
    } else {
      $fileName = $prevImage;
    }



    $stmt = $this->pdo->prepare("UPDATE `partners` SET 
    `name` = :name, 
    `descriptionInHu` = :descriptionInHu, 
    `descriptionInEn` = :descriptionInEn, 
    `link` = :link, 
    `type` = :type, 
    `fileName` = :fileName 
    WHERE `partners`.`id` = :id");

    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn, PDO::PARAM_STR);
    $stmt->bindParam(":link", $link, PDO::PARAM_STR);
    $stmt->bindParam(":type", $type, PDO::PARAM_STR);
    $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $this->alert->set('Partner sikeresen frissítve!', 'Partner sikeresen frissítve!', 'Partner sikeresen frissítve!', "success", "/admin/partners");
  }


  // GET PARTNER FOR ADMIN
  public function getPartnerById($id)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `partners` WHERE `id` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    return $partner;
  }
}
