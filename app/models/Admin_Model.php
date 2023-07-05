<?php
  class AdminModel {
    private $pdo;

    public function __construct()
    {
      $db = new Database();
      $this->pdo = $db->getConnect();
    }

    
  }
