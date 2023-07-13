<?php

class PartnerModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  public function insert($files, $body)
  {
    $fileName = $this->fileSaver->saver($files["p_image"], "/uploads/images/partners", null);
    $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInHu = filter_var($body["descriptionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionInEn = filter_var($body["descriptionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `partners` VALUES (NULL, :name, :descriptionInHu, :descriptionInEn, :fileName, :createdAt)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":descriptionInHu", $descriptionInHu);
    $stmt->bindParam(":descriptionInEn", $descriptionInEn);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();
    header("Location: /admin/partners");
  }

  public function getPartners()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `partners` ORDER BY `createdAt` DESC LIMIT 3");
    $stmt->execute();

    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $partners;
  }
}
