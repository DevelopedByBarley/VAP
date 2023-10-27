<?php
class QuestionModel extends AdminModel
{
  public function __construct()
  {
    parent::__construct();
  }

  // GET QUESTIONS FOR ADMIN AND HOME
  public function questions()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `questions`");
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $questions;
  }

  // GET SINGLE QUESTION FOR ADMIN
  public function question($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM `questions` WHERE `q_id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    return $question;
  }

  // ADD NEW QUESTION FOR ADMIN
  public function new($body)
  {
    $q_id = uniqid();
    $questionInHu = filter_var($body["questionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $questionInEn = filter_var($body["questionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $answerInHu = filter_var($body["answerInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $answerInEn = filter_var($body["answerInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $createdAt = time();

    $stmt = $this->pdo->prepare("INSERT INTO `questions` VALUES (NULL, :q_id, :questionInHu, :questionInEn, :answerInHu, :answerInEn, :createdAt)");
    $stmt->bindParam(":q_id", $q_id);
    $stmt->bindParam(":questionInHu", $questionInHu);
    $stmt->bindParam(":questionInEn", $questionInEn);
    $stmt->bindParam(":answerInHu", $answerInHu);
    $stmt->bindParam(":answerInEn", $answerInEn);
    $stmt->bindParam(":createdAt", $createdAt);

    $stmt->execute();

    if ($this->pdo->lastInsertId()) {
      header("Location: /admin/questions");
    }
  }

  // DELETE QUESTION FOR ADMIN
  public function delete($id)
  {
    $stmt = $this->pdo->prepare("DELETE  FROM `questions` WHERE `q_id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: /admin/questions");
  }


  // UPDATE QUESTION FOR ADMIN

  public function update($id, $body)
  {
    $questionInHu = filter_var($body["questionInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $questionInEn = filter_var($body["questionInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $answerInHu = filter_var($body["answerInHu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $answerInEn = filter_var($body["answerInEn"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $this->pdo->prepare("UPDATE `questions` SET 
    `questionInHu` = :questionInHu, 
    `questionInEn` = :questionInEn, 
    `answerInHu` = :answerInHu, 
    `answerInEn` = :answerInEn
    WHERE `questions`.`q_id` = :id;");

    $stmt->bindParam(":questionInHu", $questionInHu);
    $stmt->bindParam(":questionInEn", $questionInEn);
    $stmt->bindParam(":answerInHu", $answerInHu);
    $stmt->bindParam(":answerInEn", $answerInEn);
    $stmt->bindParam(":id", $id);

    $stmt->execute();

    header("Location: /admin/questions");
  }
}
