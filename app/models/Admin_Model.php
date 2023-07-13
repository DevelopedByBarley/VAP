<?php

class AdminModel
{
  protected $pdo;
  protected $fileSaver;


  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
    $this->fileSaver = new FileSaver();
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
