<?php
class LinkModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `links` ORDER BY `createdAt` DESC");
    $stmt->execute();
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $links;
  }


  // GET ALL OF LINKS FOR ADMIN AND HOME
  public function links()
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM links");
    $stmt->execute();
    $countOfRecords = $stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];


    $offset = $_GET["offset"] ?? 1;
    $limit = 7; // Az oldalanként megjelenített rekordok száma
    $calculated = ($offset - 1) * $limit; // Az OFFSET értékének kiszámítása
    $numOfPage = ceil($countOfRecords / $limit); // A lapozó lapok számának kiszámítása

    $stmt = $this->pdo->prepare("SELECT * FROM `links` ORDER BY `createdAt` DESC LIMIT $limit OFFSET $calculated");
    $stmt->execute();
    $links = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      "links" => $links,
      "numOfPage" => $numOfPage,
      "limit" => $limit
    ];
  }

  // INSERT LINKS FOR ADMIN
  public function insert($body)
  {
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $link = filter_var($body["link"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `links` VALUES (NULL, :nameInHu, :nameInEn, :link, :createdAt)");
    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();
    header("Location: /admin/links");
  }

  // DELETE LINKS FOR ADMIN
  public function delete($id)
  {

    $stmt = $this->pdo->prepare("DELETE FROM `links` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/links");
  }


  // UPDATE LINKS FRO ADMIN
  public function update($id, $body)
  {
    $nameInHu = filter_var($body["nameInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $nameInEn = filter_var($body["nameInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $link = filter_var($body["link"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);


    $stmt = $this->pdo->prepare("UPDATE `links` SET 
    `nameInHu` = :nameInHu, 
    `nameInEn` = :nameInEn, 
    `link` = :link
    WHERE `links`.`id` = :id");

    $stmt->bindParam(":nameInHu", $nameInHu);
    $stmt->bindParam(":nameInEn", $nameInEn);
    $stmt->bindParam(":link", $link);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location:  /admin/links");
  }

  // GET LINK BY ID FOR ADMIN
  public function getLinkById($id)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM `links` WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    return $partner;
  }
}
