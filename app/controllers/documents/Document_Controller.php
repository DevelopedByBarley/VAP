<?php
require 'app/models/Document_Model.php';

class DocumentController extends AdminController
{
  protected $documentModel;

  public function __construct()
  {
    parent::__construct();
    $this->documentModel = new DocumentModel();
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
