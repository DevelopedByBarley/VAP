<?php
require_once 'app/models/Admin_Model.php';
require_once 'app/helpers/LoginChecker.php';
require_once 'app/services/AuthService.php';
require_once 'app/helpers/FileSaver.php';
require_once 'app/models/Admin_Model.php';

class Gallery_Model extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getGallery($offset = 1)
  {
    $limit = 12; // Az oldalanként megjelenített képek száma
    $calculated = ($offset - 1) * $limit; // Az OFFSET értékének kiszámítása

    // Összes rekord számának lekérdezése
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `gallery`");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása

    // Paginated lekérdezés
    $query = "SELECT * FROM gallery ORDER BY created_at DESC LIMIT $limit OFFSET $calculated";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);


    return [
      "gallery" => $gallery,
      "offset" => $offset,
      "numOfPage" => $numOfPage,
      "limit" => $limit,
      "countOfRecords" => $countOfRecords
    ];
  }

  public function getAllGalleryImages()
  {
    $query = "SELECT * FROM gallery ORDER BY created_at DESC";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addImage($fileName, $description, $is_public, $event_id = null)
  {
    var_dump($event_id);
    $query = "INSERT INTO gallery (fileName, description, is_public, event_id) VALUES (:fileName, :description, :is_public, :event_id)";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':fileName', $fileName);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':is_public', $is_public, PDO::PARAM_INT);
    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getGalleryImageById($id)
  {
    $query = "SELECT * FROM gallery WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function deleteImage($id)
  {
    $query = "DELETE FROM gallery WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
