<?php
class DocumentModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `documents` ORDER BY `createdAt`");
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $documents;
  }

  public function documents()
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM documents");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];


    $offset = $_GET["offset"] ?? 1;
    $limit = 7; // Az oldalanként megjelenített rekordok száma
    $calculated = ($offset - 1) * $limit; // Az OFFSET értékének kiszámítása
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása

    $stmt = $this->pdo->prepare("SELECT * FROM `documents` ORDER BY `createdAt` DESC LIMIT $limit OFFSET $calculated");
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      "documents" => $documents,
      "numOfPage" => $numOfPage,
      "limit" => $limit
    ];
  }

  public function insertDocument($files, $body)
  {

    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();
    $file = $files["file"];
    $tmpFilePath = $file["tmp_name"];
    $rand = uniqid();

    $fileName = $file["name"];

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExtensions = ["pdf", "txt", "doc"];
    if (in_array($fileExtension, $allowedExtensions)) {
      $directoryPath = "./public/assets/uploads/documents/";
      $originalFileName = $rand . '.' . $fileExtension;
      $destination = $directoryPath . $originalFileName;

      move_uploaded_file($tmpFilePath, $destination);

      $stmt = $this->pdo->prepare("INSERT INTO `documents` VALUES (NULL, :nameInHu, :nameInEn, :fileName, :extension, :createdAt)");
      $stmt->bindParam(":nameInHu", $nameInHu);
      $stmt->bindParam(":nameInEn", $nameInEn);
      $stmt->bindParam(":fileName", $originalFileName);
      $stmt->bindParam(":extension", $fileExtension);
      $stmt->bindParam(":createdAt", $createdAt);

      $stmt->execute();

      if ($this->pdo->lastInsertId()) {
        header("Location: /admin/documents");
      }
    }
  }

  public function delete($id)
  {
    $fileNameForDelete = self::getDocumentById($id)["fileName"];
    unlink("./public/assets/uploads/documents/$fileNameForDelete");

    $stmt = $this->pdo->prepare("DELETE FROM `documents` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/documents");
  }

  public function update($id, $files, $body)
  {
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $prevImage = self::getDocumentById($id)["fileName"];
    $fileName = '';
    $fileExtension = '';

    if ($files["file"]["name"] !== '') {
      unlink("./public/assets/uploads/documents/$prevImage");
      $file = $files["file"];
      $tmpFilePath = $file["tmp_name"];
      $rand = uniqid();

      $newFileName = $file["name"];

      $fileExtension = pathinfo($newFileName, PATHINFO_EXTENSION);
      $allowedExtensions = ["pdf", "txt", "doc"];
      if (in_array($fileExtension, $allowedExtensions)) {
        $directoryPath = "./public/assets/uploads/documents/";
        $originalFileName = $rand . '.' . $fileExtension;
        $destination = $directoryPath . $originalFileName;

        move_uploaded_file($tmpFilePath, $destination);

        $fileName = $originalFileName;
      }
    } else {
      $fileName = $prevImage;
      $fileExtension = self::getDocumentById($id)["extension"];
    }

    $stmt = $this->pdo->prepare("UPDATE `documents` SET 
    `nameInHu` = :nameInHu, 
    `nameInEn` = :nameInEn, 
    `fileName` = :fileName,
    `extension` = :extension
    WHERE `documents`.`id` = :id");

    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":fileName", $fileName);
    $stmt->bindParam(":extension", $fileExtension);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/documents");
  }

  public function getDocumentById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `documents` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    return $partner;
  }
}
