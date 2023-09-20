<?php
require 'app/models/Admin_Model.php';
class VolunteerModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getVolunteers()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `volunteers` ORDER BY `createdAt` DESC LIMIT 3");
    $stmt->execute();

    $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $volunteers;
  }


  public function addVolunteer($files, $body)
  {
    $fileName = $this->fileSaver->saver($files["v_image"], "/uploads/images/volunteers", null, [
      'image/png',
      'image/jpeg',
    ]);
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["description"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `volunteers` VALUES (NULL, :name, :descriptionInHu, :descriptionInEn, :fileName, :createdAt)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();
    header("Location: /admin/volunteers");
  }

  public  function deleteVolunteer($id)
  {
    $fileNameForDelete = self::getVolunteerByCommonId($id)["fileName"];
    unlink("./public/assets/uploads/images/volunteers/$fileNameForDelete");

    $stmt = $this->pdo->prepare("DELETE FROM `volunteers` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/volunteers");
  }

  public function getVolunteerByCommonId($id)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `volunteers` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $volunteer = $stmt->fetch(PDO::FETCH_ASSOC);

    return $volunteer;
  }



  public function update($files, $id, $body)
  {
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $descriptionInHu = filter_var($body["description"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $prevImage = self::getPrevImageByVolunteer($id)["fileName"];
    $fileName = '';



    if ($files["v_image"]["name"] !== '') {
      unlink("./public/assets/uploads/images/volunteers/$prevImage");
      $fileName = $this->fileSaver->saver($files["v_image"], "/uploads/images/volunteers", null, [
        'image/png',
        'image/jpeg',
      ]);
    } else {
      $fileName = $prevImage;
    }



    $stmt = $this->pdo->prepare("UPDATE `volunteers` SET 
    `name` = :name, 
    `descriptionInHu` = :descriptionInHu, 
    `descriptionInEn` = :descriptionInEn, 
    `fileName` = :fileName 
    WHERE `volunteers`.`id` = :id");

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/volunteers");
  }

  private  function getPrevImageByVolunteer($id)
  {

    $stmt = $this->pdo->prepare("SELECT `fileName` from `volunteers` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $fileName = $stmt->fetch(PDO::FETCH_ASSOC);

    return $fileName;
  }
}
