<?php
require 'app/models/Partner_Model.php';

class PartnerController
{
  protected $partnerModel;
  protected $renderer;
  protected $adminModel;

  public function __construct()
  {
    $this->partnerModel = new PartnerModel();
    $this->renderer = new Renderer();
    $this->adminModel = new AdminModel();
  }

  // PROTECTED

  public function newPartner()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->partnerModel->insert($_FILES, $_POST);
  }

  public function deletePartner($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->partnerModel->delete($vars["id"]);
  }

  
  public function updatePartner($vars) {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $this->partnerModel->update($_FILES, $vars["id"], $_POST);
  }
}
