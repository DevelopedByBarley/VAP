<?php
require 'app/models/Document_Model.php';

class DocumentController
{
  protected $documentModel;
  protected $renderer;
  protected $adminModel;

  public function __construct()
  {
    $this->documentModel = new DocumentModel();
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
  }

  public function uploadDocument()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->documentModel->insertDocument($_FILES, $_POST);
  }
  
  public function updateDocument($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->documentModel->update($vars["id"], $_FILES, $_POST);
  }
  
  public function deleteDocument($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->documentModel->delete($vars["id"]);
  }
}
