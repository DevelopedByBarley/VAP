<?php
class PartnerRender extends PartnerController{

  public function __construct()
  {
    parent::__construct();
   
  }

  public function index()
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $partnersData = $this->partnerModel->getPartners();


    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/partners/Partners.php", [
        "admin" => $admin ?? null,
        "partners" => $partnersData["partners"] ?? null,
        "numOfPage" => $partnersData["numOfPage"] ?? null,
        "limit" => $partnersData["limit"] ?? null
      ]),
      "admin" => $admin ?? null
    ]);
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


  public function updatePartnerForm($vars)
  {
    LoginChecker::checkUserIsLoggedInOrRedirect("adminId", "/admin");
    $admin = $this->adminModel->admin();
    $partner = $this->partnerModel->getPartnerById($vars["id"]);
    echo $this->renderer->render("Layout.php", [
      "content" => $this->renderer->render("/pages/admin/partners/UpdateForm.php", [
        "admin" => $admin ?? null,
        "partner" => $partner ?? null
      ]),
      "admin" => $admin ?? null
    ]);
  }
}
