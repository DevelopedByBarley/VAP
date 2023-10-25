<?php
class DocumentModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }


  // GET ALL DOCUMENTS OF WEBSITE
  public function index()
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM documents");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];


    $offset = $_GET["offset"] ?? 1;
    $limit = 7;
    $calculated = ($offset - 1) * $limit;
    $numOfPage = ceil($countOfRecords / $limit);

    $stmt = $this->pdo->prepare("SELECT * FROM `documents` ORDER BY `createdAt` DESC LIMIT $limit OFFSET $calculated");
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      "documents" => $documents,
      "numOfPage" => $numOfPage,
      "limit" => $limit
    ];
  }

  // ADD NEW DOCUMENT TO WEBSITE
  public function new($files, $body)
  {
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $documentName = $this->fileSaver->saver($files["document"], "/uploads/documents/admin", null, [
      'application/pdf',
      'application/msword',
    ]);
    $extension =  pathinfo($documentName, PATHINFO_EXTENSION);



    $stmt = $this->pdo->prepare("INSERT INTO `documents` VALUES (NULL, :nameInHu, :nameInEn, :fileName, :extension, :createdAt)");
    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":fileName", $documentName);
    $stmt->bindParam(":extension", $extension);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();

    if ($this->pdo->lastInsertId()) {
      header("Location: /admin/documents");
    }
  }


  // DELETE DOCUMENT FROM WEBSITE
  public function delete($id)
  {
    $fileNameForDelete = self::getDocumentById($id)["fileName"];
    unlink("./public/assets/uploads/documents/admin/$fileNameForDelete");

    $stmt = $this->pdo->prepare("DELETE FROM `documents` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/documents");
  }


  // UPDATE DOCUMENT OF WEBSITE
  public function update($id, $files, $body)
  {
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $prevImage = self::getDocumentById($id)["fileName"];
    $documentName = '';
    $extension = '';

    if (!empty($files["document"]["name"])) {
      $documentName = $this->fileSaver->saver($files["document"], "/uploads/documents/admin", $prevImage, [
        'application/pdf',
        'application/msword',
      ]);

      
    } else {
      $documentName = $prevImage;
    }

    $extension = pathinfo($documentName, PATHINFO_EXTENSION);


    $stmt = $this->pdo->prepare("UPDATE `documents` SET 
    `nameInHu` = :nameInHu, 
    `nameInEn` = :nameInEn, 
    `fileName` = :fileName,
    `extension` = :extension
    WHERE `documents`.`id` = :id");

    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":fileName", $documentName);
    $stmt->bindParam(":extension", $extension);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/documents");
  }




  // GET DOCUMENT BY ID
  public function getDocumentById($id)
  {
   
    $stmt = $this->pdo->prepare("SELECT * FROM `documents` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    return $partner;
  }
}
