<?php
require 'app/models/Document_Model.php';

class DocumentController extends AdminController
{
  private $documentModel;

  public function __construct()
  {
    parent::__construct();
    $this->documentModel = new DocumentModel();
  }

  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $documentsData = $this->documentModel->documents();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/documents/Documents.php", [
        "admin" => $admin ?? null,
        "documents" => $documentsData["documents"] ?? null,
        "numOfPage" => $documentsData["numOfPage"] ?? null,
        "limit" => $documentsData["limit"] ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }

  
  public function documentForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/documents/Form.php", [
        "admin" => $admin ?? null,
      ]),
      "admin" => $admin ?? null
    ]);
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

  public function updateForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $document = $this->documentModel->getDocumentById($vars["id"]);
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/documents/UpdateForm.php", [
        "admin" => $admin ?? null,
        "document" => $document ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
