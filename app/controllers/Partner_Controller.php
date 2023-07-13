<?php
require 'app/models/Partner_Model.php';

class PartnerController extends AdminController
{
  private $partnerModel;

  public function __construct()
  {
    parent::__construct();
    $this->partnerModel = new PartnerModel();
  }

  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $partners = $this->partnerModel->getPartners();
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/partners/Partners.php", [
        "admin" => $admin ?? null,
        "partners" => $partners
      ]),
      "admin" => $admin ?? null
    ]);
  }


  public function newPartner()
  {
    $this->partnerModel->insert($_FILES, $_POST);
  }
  public function partnerForm()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/partners/Form.php", [
        "admin" => $admin ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
