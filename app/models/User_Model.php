<?php
class UserModel
{
  private $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getConnect();
  }


  public function register($body)
  {
    echo "<pre>";
    var_dump($body);
    exit;
  }
}
