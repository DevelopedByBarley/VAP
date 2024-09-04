<?php
require_once 'app/models/Admin_Model.php';
class VolunteerModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  // GET VOLUNTEERS FOR ADMIN AND HOME
  public function getVolunteers()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `volunteers` ORDER BY `createdAt` DESC LIMIT 3");
    $stmt->execute();

    $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $volunteers;
  }

  // INSERT VOLUNTEER FOR ADMIN
  public function addVolunteer($files, $body)
  {
    $fileName = $this->fileSaver->saver($files["v_image"], "/uploads/images/volunteers", null, [
      'image/png',
      'image/jpeg',
    ]);

    if (!$fileName) {
      $this->alert->set("Feltöltött fénykép file típus elutasítva", "Feltöltött fénykép file típus elutasítva", null, "danger", "/admin/volunteers/new");
    }
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["description"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `volunteers` VALUES (NULL, :name, :descriptionInHu, :descriptionInEn, :fileName, :createdAt)");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn, PDO::PARAM_STR);
    $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":createdAt", $createdAt, PDO::PARAM_INT);

    $stmt->execute();
    $this->alert->set('Új önkéntes sikeresen hozzáadva!', 'Új önkéntes sikeresen hozzáadva!', 'Új önkéntes sikeresen hozzáadva!', "success", "/admin/volunteers");
  }

  // DELETE VOLUNTEER FOR ADMIN
  public  function deleteVolunteer($id)
  {
    $fileNameForDelete = self::getVolunteerByCommonId($id)["fileName"];
    unlink("./public/assets/uploads/images/volunteers/$fileNameForDelete");

    $stmt = $this->pdo->prepare("DELETE FROM `volunteers` WHERE `id` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $this->alert->set('Önkéntes sikeresen törölve!', 'Önkéntes sikeresen törölve!',  'Önkéntes sikeresen törölve!', "success", "/admin/volunteers");
  }

  // GET SINGLE VOLUNTEER FOR ADMIN
  public function getVolunteerByCommonId($id)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `volunteers` WHERE `id` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $volunteer = $stmt->fetch(PDO::FETCH_ASSOC);

    return $volunteer;
  }


  // UPDATE VOLUNTEER FOR ADMIN
  public function update($files, $id, $body)
  {
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $descriptionInHu = filter_var($body["description"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $prevImage = self::getPrevImageByVolunteer($id)["fileName"];
    $fileName = '';



    if ($files["v_image"]["name"] !== '') {
      $fileName = $this->fileSaver->saver($files["v_image"], "/uploads/images/volunteers", null, [
        'image/png',
        'image/jpeg',
      ]);
      if (!$fileName) {
        $this->alert->set("File típus elutasítva", "File type rejected", null, "danger", "/admin/volunteers/update/" . $id);
      }
      unlink("./public/assets/uploads/images/volunteers/$prevImage");
    } else {
      $fileName = $prevImage;
    }

   

    $stmt = $this->pdo->prepare("UPDATE `volunteers` SET 
    `name` = :name, 
    `descriptionInHu` = :descriptionInHu, 
    `descriptionInEn` = :descriptionInEn, 
    `fileName` = :fileName 
    WHERE `volunteers`.`id` = :id");

    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu, PDO::PARAM_STR);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn, PDO::PARAM_STR);
    $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();


    $this->alert->set('Önkéntes sikeresen frissítve!', 'Önkéntes sikeresen frissítve!', 'Önkéntes sikeresen frissítve!', "success", "/admin/volunteers");
  }



  // GET PREV IMAGE FOR VOLUNTEER 
  private  function getPrevImageByVolunteer($id)
  {

    $stmt = $this->pdo->prepare("SELECT `fileName` from `volunteers` WHERE `id` = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $fileName = $stmt->fetch(PDO::FETCH_ASSOC);

    return $fileName;
  }
}
